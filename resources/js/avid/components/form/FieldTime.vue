<script setup lang="ts">
import { Field, HasInline, HasPlaceholder, HasSize } from '@/avid/types/form';
import dayjs from 'dayjs';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder, HasInline {}

withDefaults(defineProps<Props>(), {});

const model = defineModel<string | null | undefined>();

const date = computed<Date | (Date | null)[] | null>(() => {
    if (!model.value) return null;

    return new Date(dayjs().format('YYYY-MM-DD') + ' ' + model.value);
});

const onUpdate = (value: Date | Date[] | (Date | null)[] | null | undefined) => {
    if (!value) {
        model.value = null;
        return;
    }

    if (Array.isArray(value)) {
        model.value = null;
        return;
    }

    model.value = dayjs(value).format('HH:mm');
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
                :inline="inline"
                time-only
                @update:model-value="onUpdate"
            >
                <template #inputicon="slotProps">
                    <i class="pi pi-clock" @click="slotProps.clickCallback" />
                </template>
            </PrimeDatePicker>
        </template>
    </FormControl>
</template>
