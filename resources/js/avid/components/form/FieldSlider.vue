<script setup lang="ts">
import { Field, HasMax, HasMin, HasOrientation, HasRange, HasStep } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasMin, HasMax, HasStep, HasOrientation, HasRange {}

withDefaults(defineProps<Props>(), {});

const model = defineModel<number | number[] | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeSlider
                :id="name"
                v-model="model"
                :name="name"
                fluid
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :min="min"
                :max="max"
                :step="step"
                :orientation="orientation"
                :range="range"
            />
        </template>
    </FormControl>
</template>
