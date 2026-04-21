<script setup lang="ts">
import { Field, HasPlaceholder, HasSize } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder {
    type?: string;
}

withDefaults(defineProps<Props>(), {
    type: 'text',
});

const model = defineModel<string | null | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeInputText
                :id="name"
                v-model="model"
                :type="type"
                :name="name"
                :size="size"
                fluid
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
            />
        </template>
    </FormControl>
</template>
