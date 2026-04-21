<script setup lang="ts">
import { Field, CanBeTranslated } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, CanBeTranslated {
    height?: string;
}

const props = withDefaults(defineProps<Props>(), {
    height: '300px',
    defaultLocale: 'it',
    locales: () => [
        { label: 'Italiano', key: 'it' },
        { label: 'English', key: 'en' },
    ],
});

const model = defineModel<object | undefined>();

const editorStyle = computed(() => `height: ${props.height}`);

const currentLocale = ref(props.defaultLocale);

const computedModel = computed(() => {
    if (! model.value) return undefined;

    return model.value[currentLocale.value]
})

const onUpdateModel = (value: string | null | undefined) => {
    if (! model.value) {
        model.value = {}    
    }

    model.value[currentLocale.value] = value
}
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <div class="flex flex-wrap gap-3 -mb-1.5 -mt-1">
                <button
                    v-for="locale in locales" :key="locale.key"
                    class="text-sm cursor-pointer"
                    :class="{
                        'text-primary-500 dark:text-primay-400': locale.key === currentLocale,
                        'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-100': locale.key !== currentLocale,
                    }"
                    @click="currentLocale = locale.key"
                >
                    {{ locale.label }}
                </button>
            </div>

            <PrimeEditor
                :id="name"
                :model-value="computedModel"
                :name="name"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :editor-style="editorStyle"
                @update:model-value="onUpdateModel"
            />
        </template>
    </FormControl>
</template>
