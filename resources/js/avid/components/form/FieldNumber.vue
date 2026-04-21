<script setup lang="ts">
import { Field, HasMax, HasMin, HasPlaceholder, HasPrefix, HasSize, HasStep, HasSuffix } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder, HasMin, HasMax, HasStep, HasPrefix, HasSuffix {
    mode?: 'decimal' | 'currency';
    currency?: string;
    showButtons?: boolean;
    minFractionDigits?: number;
    maxFractionDigits?: number;
}

withDefaults(defineProps<Props>(), {
    mode: 'decimal',
});

const model = defineModel<number | null | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeInputNumber
                :id="name"
                v-model="model"
                :mode="mode"
                :currency="currency ?? undefined"
                :name="name"
                :size="size"
                fluid
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :min="min"
                :max="max"
                :step="step"
                :prefix="prefix"
                :suffix="suffix"
                :show-buttons="showButtons"
                :min-fraction-digits="minFractionDigits"
                :max-fraction-digits="maxFractionDigits"
            />
        </template>
    </FormControl>
</template>
