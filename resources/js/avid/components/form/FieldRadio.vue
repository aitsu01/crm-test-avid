<script setup lang="ts">
import { Field, HasInline, HasOptions, HasSize } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasInline, HasOptions {
    type?: string;
}

withDefaults(defineProps<Props>(), {
    type: 'text',
});

const model = defineModel<any>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <PrimeRadioButtonGroup
            v-model="model"
            :name="name"
            class="flex flex-wrap"
            :class="{
                'flex-col gap-2': !inline,
                'gap-4': inline,
            }"
        >
            <template v-if="options">
                <template v-for="option in options" :key="option.value">
                    <div class="flex items-center gap-2">
                        <PrimeRadioButton :input-id="option.key" :value="option.key" :size="size" :disabled="disabled" :readonly="readonly" />
                        <label :for="option.key">{{ option.label }}</label>
                    </div>
                </template>
            </template>
        </PrimeRadioButtonGroup>
    </FormControl>
</template>
