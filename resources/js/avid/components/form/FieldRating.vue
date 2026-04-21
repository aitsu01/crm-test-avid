<script setup lang="ts">
import { Field } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field {
    stars?: number;
}

withDefaults(defineProps<Props>(), {});

const model = defineModel<number | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeRating :id="name" v-model="model" :name="name" :disabled="disabled" :readonly="readonly" :invalid="invalid" :stars="stars" />
        </template>
    </FormControl>
</template>
