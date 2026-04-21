<script setup lang="ts">
import { Field, HasPlaceholder, HasSize } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder {
    cols?: number;
    rows?: number;
    autoResize?: boolean;
}

withDefaults(defineProps<Props>(), {});

const model = defineModel<string | null | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeTextarea
                :id="name"
                v-model="model"
                :name="name"
                :size="size"
                fluid
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :cols="cols"
                :rows="rows"
                :auto-resize="autoResize"
            />
        </template>
    </FormControl>
</template>
