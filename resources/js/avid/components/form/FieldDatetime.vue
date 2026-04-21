<script setup lang="ts">
import { Field, HasInline, HasMaxDate, HasMinDate, HasMultiple, HasPlaceholder, HasRange, HasSize } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder, HasMinDate, HasMaxDate, HasRange, HasMultiple, HasInline { }

const props = withDefaults(defineProps<Props>(), {});

const model = defineModel<string | (string | null)[] | null | undefined>();

const computedDate = computed(() => {
    if (!model.value) return null;

    if (Array.isArray(model.value)) {
        return [...model.value]
    }

    return new Date(model.value);
});

const computedMinDate = computed(() => {
    if (!props.minDate) return undefined;

    return new Date(props.minDate);
});

const computedMaxDate = computed(() => {
    if (!props.maxDate) return undefined;

    return new Date(props.maxDate);
});

const selectionMode = computed(() => {
    if (props.range) return 'range';

    if (props.multiple) return 'multiple';

    return undefined;
});

const manualInput = computed(() => {
    return !(props.range || props.multiple);
});

const onUpdateModelValue = (value: Date | (Date | null)[]) => {
    if (!value) {
        model.value = null;
        return;
    }

    if (Array.isArray(value)) {
        model.value = [...value];
        return;
    }

    model.value = value.toISOString();
};

const onClear = () => {
    model.value = null;
};
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeDatePicker :id="name" :model-value="computedDate" :name="name" :size="size" :placeholder="placeholder"
                :disabled="disabled" :readonly="readonly" :invalid="invalid" fluid show-icon icon-display="input"
                show-button-bar :min-date="computedMinDate" :max-date="computedMaxDate" :selection-mode="selectionMode"
                :manual-input="manualInput" :inline="inline" show-time date-format="dd/mm/yy" @clear-click="onClear"
                @update:model-value="onUpdateModelValue" />
        </template>
    </FormControl>
</template>
