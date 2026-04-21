<script setup lang="ts">
import { Field } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field {
    height?: string;
}

const props = withDefaults(defineProps<Props>(), {
    height: '300px',
});

const model = defineModel<string | undefined>();

const editorStyle = computed(() => `height: ${props.height}`);
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeEditor
                :id="name"
                v-model="model"
                :name="name"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :editor-style="editorStyle"
            />
        </template>
    </FormControl>
</template>
