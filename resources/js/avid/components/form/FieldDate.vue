<script setup lang="ts">
import { Field, HasInline, HasMaxDate, HasMinDate, HasMultiple, HasPlaceholder, HasRange, HasSize } from '@/avid/types/form';
import dayjs from 'dayjs';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder, HasMinDate, HasMaxDate, HasRange, HasMultiple, HasInline {}

const props = withDefaults(defineProps<Props>(), {});

const model = defineModel<string | (string | null)[] | null | undefined>();

const date = computed<Date | (Date | null)[] | null>(() => {
    if (!model.value) return null;

    if (Array.isArray(model.value)) {
        return model.value.map((d) => (d ? new Date(d) : null));
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

const onUpdate = (value: Date | Date[] | (Date | null)[] | null | undefined) => {
    if (!value) {
        model.value = null;
        return;
    }

    if (Array.isArray(value)) {
        model.value = value.map((d) => (d ? dayjs(d).format('YYYY-MM-DD') : null));
        return;
    }

    model.value = dayjs(value).format('YYYY-MM-DD');
};

const onClear = () => {
    model.value = null;
};
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeDatePicker
                :id="name"
                :model-value="date"
                :name="name"
                :size="size"
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                fluid
                show-icon
                icon-display="input"
                show-button-bar
                :min-date="computedMinDate"
                :max-date="computedMaxDate"
                :selection-mode="selectionMode"
                :manual-input="manualInput"
                :inline="inline"
                class="!w-full"
                date-format="dd/mm/yy"
                @update:model-value="onUpdate"
                @clear-click="onClear"
            />
        </template>
    </FormControl>
</template>
