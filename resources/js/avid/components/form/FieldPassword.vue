<script setup lang="ts">
import { Field, HasPlaceholder, HasSize } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder {
    feedback?: boolean;
    toggleMask?: boolean;
}

withDefaults(defineProps<Props>(), {
    feedback: false,
});

const model = defineModel<string | null | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimePassword
                :id="name"
                v-model="model"
                :name="name"
                :size="size"
                fluid
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :feedback="feedback"
                :toggle-mask="toggleMask"
            />
        </template>
    </FormControl>
</template>
