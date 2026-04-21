<script setup lang="ts">
import { Field, HasSize } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize {
    type?: string;
}

withDefaults(defineProps<Props>(), {
    type: 'text',
});

const model = defineModel<string | null | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <PrimeMessage variant="simple" severity="contrast" :size="size">
            {{ model }}
        </PrimeMessage>
    </FormControl>
</template>
