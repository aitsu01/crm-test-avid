<script setup lang="ts">
import { Field, HasInline } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasInline {
    format?: 'hex' | 'rgb' | 'hsb';
}

withDefaults(defineProps<Props>(), {
    format: 'hex',
});

const model = defineModel<string | null | undefined>();

const computedModel = computed(() => {
    if (! model.value) return null;

    return model.value.replace('#', '');
})

const onUpdateModel = (value: string|null) => {
    if (!value) {
        model.value = null;
        return;
    }

    model.value = '#' + value;
}
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeColorPicker
                :id="name"
                :model-value="computedModel"
                :name="name"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :inline="inline"
                :format="format"
                :pt="{
                    preview: 'border'
                }"
                @update:model-value="onUpdateModel"
            />
        </template>
    </FormControl>
</template>
