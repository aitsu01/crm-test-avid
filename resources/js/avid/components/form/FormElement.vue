<script setup lang="ts">
import { useCondition } from '@/avid/composables/useCondition';
import { Schema } from '@/avid/types/form';

const props = defineProps<{
    schema: Schema;
}>();

const inertiaForm = defineModel<any>('inertiaForm');

const componentsMap: any = {
    FieldText: defineAsyncComponent(() => import('./FieldText.vue')),
    FieldNumber: defineAsyncComponent(() => import('./FieldNumber.vue')),
    FieldTextarea: defineAsyncComponent(() => import('./FieldTextarea.vue')),
    FieldColor: defineAsyncComponent(() => import('./FieldColor.vue')),
    FieldCheckbox: defineAsyncComponent(() => import('./FieldCheckbox.vue')),
    FieldPassword: defineAsyncComponent(() => import('./FieldPassword.vue')),
    FieldRating: defineAsyncComponent(() => import('./FieldRating.vue')),
    FieldSlider: defineAsyncComponent(() => import('./FieldSlider.vue')),
    FieldEditor: defineAsyncComponent(() => import('./FieldEditor.vue')),
    FieldPlaceholder: defineAsyncComponent(() => import('./FieldPlaceholder.vue')),
    FieldRadio: defineAsyncComponent(() => import('./FieldRadio.vue')),
    FieldDate: defineAsyncComponent(() => import('./FieldDate.vue')),
    FieldDatetime: defineAsyncComponent(() => import('./FieldDatetime.vue')),
    FieldAutocomplete: defineAsyncComponent(() => import('./FieldAutocomplete.vue')),
    FieldTime: defineAsyncComponent(() => import('./FieldTime.vue')),
    FieldSelect: defineAsyncComponent(() => import('./FieldSelect.vue')),
    FieldTreeSelect: defineAsyncComponent(() => import('./FieldTreeSelect.vue')),
    FieldMask: defineAsyncComponent(() => import('./FieldMask.vue')),
    FieldMultiSelect: defineAsyncComponent(() => import('./FieldMultiSelect.vue')),
    FieldFile: defineAsyncComponent(() => import('./FieldFile.vue')),
    FieldFiles: defineAsyncComponent(() => import('./FieldFiles.vue')),
    FieldTranslatableEditor: defineAsyncComponent(() => import('./FieldTranslatableEditor.vue')),
    FieldTranslatableText: defineAsyncComponent(() => import('./FieldTranslatableText.vue')),
    FieldTranslatableTextarea: defineAsyncComponent(() => import('./FieldTranslatableTextarea.vue')),

    LayoutGrid: defineAsyncComponent(() => import('./LayoutGrid.vue')),
    LayoutColumn: defineAsyncComponent(() => import('./LayoutColumn.vue')),
    LayoutSection: defineAsyncComponent(() => import('./LayoutSection.vue')),
    LayoutFieldset: defineAsyncComponent(() => import('./LayoutFieldset.vue')),
    LayoutWizard: defineAsyncComponent(() => import('./LayoutWizard.vue')),
};

const componentName = computed(() => {
    return componentsMap[props.schema.component] ?? null;
});

const { evaluateCondition } = useCondition();

const visible = computed(() => {
    if (props.schema.conditions.hidden) {
        return !evaluateCondition(inertiaForm.value, props.schema.conditions.hidden);
    }

    if (props.schema.conditions.visible) {
        return evaluateCondition(inertiaForm.value, props.schema.conditions.visible);
    }

    return true;
});

const required = computed(() => {
    if (!props.schema.conditions.required) {
        return props.schema.props?.required;
    }

    return evaluateCondition(inertiaForm.value, props.schema.conditions.required);
});

const disabled = computed(() => {
    if (!props.schema.conditions.disabled) {
        return props.schema.props?.disabled;
    }

    return evaluateCondition(inertiaForm.value, props.schema.conditions.disabled);
});

const readonly = computed(() => {
    if (!props.schema.conditions.readonly) {
        return props.schema.props?.readonly;
    }

    return evaluateCondition(inertiaForm.value, props.schema.conditions.readonly);
});

const params = computed(() => {
    if (!props.schema.props.parent) {
        return props.schema.props.params ?? undefined;
    }

    const params: any = {};

    if (props.schema.props.params) {
        for (const param of props.schema.props.params) {
            params[param] = props.schema.props.params[param];
        }
    }

    if (Array.isArray(props.schema.props.parent)) {
        for (const param of props.schema.props.parent) {
            params[param] = inertiaForm.value[param];
        }
    } else {
        params[props.schema.props.parent] = inertiaForm.value[props.schema.props.parent];
    }

    return params;
});
</script>

<template>
    <component v-if="schema.type === 'layout'" :is="componentName" v-model:inertia-form="inertiaForm" v-bind="schema.props" />

    <component
        v-else
        :is="componentName"
        v-model="inertiaForm[schema.props.name]"
        v-bind="schema.props"
        v-show="visible"
        :required="required"
        :disabled="disabled"
        :readonly="readonly"
        :error="inertiaForm.errors[schema.props.name]"
        :params="params"
    />
</template>
