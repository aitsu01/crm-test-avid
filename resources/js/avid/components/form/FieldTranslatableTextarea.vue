<script setup lang="ts">
import { Field, HasPlaceholder, HasSize, CanBeTranslated } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder, CanBeTranslated {
    cols?: number;
    rows?: number;
    autoResize?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    defaultLocale: 'it',
    locales: () => [
        { label: 'Italiano', key: 'it' },
        { label: 'English', key: 'en' },
    ],
});

const model = defineModel<object | null | undefined>();

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

            <PrimeTextarea
                :id="name"
                :model-value="computedModel"
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
                @update:model-value="onUpdateModel"
            />
        </template>
    </FormControl>
</template>
