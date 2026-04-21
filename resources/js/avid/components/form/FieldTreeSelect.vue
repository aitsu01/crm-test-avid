<script setup lang="ts">
import {
    Field,
    HasAsync,
    HasClearable,
    HasFilter,
    HasFooter,
    HasHeader,
    HasMultiple,
    HasOptions,
    HasPlaceholder,
    HasSize,
    Option,
} from '@/avid/types/form';
import { useDebounceFn } from '@vueuse/core';
import axios from 'axios';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder, HasOptions, HasHeader, HasFooter, HasMultiple, HasClearable, HasAsync, HasFilter {}

const props = defineProps<Props>();

const model = defineModel<string | number | (string | number)[] | null | undefined>();

const selected = ref<any>(undefined);

const search = ref<string | undefined>();
const loading = ref(false);
const asyncOptions = ref<Option[]>([]);

const selectionMode = computed(() => {
    if (props.multiple) {
        return 'checkbox';
    }

    return undefined;
});

const currentOptions = computed(() => {
    if (props.async) {
        return asyncOptions.value;
    } else {
        return props.options;
    }
});

const onLoad = useDebounceFn(async () => {
    if (!props.async) return;

    loading.value = true;

    const { data } = await axios.get(props.async, {
        params: {
            search: search.value,
            ...(props.params ?? {}),
        },
    });

    asyncOptions.value = data;

    loading.value = false;
}, 300);

const setSelection = () => {
    let newSelection: any = undefined;
    if (selectionMode.value === 'checkbox') {
        if (Array.isArray(model.value)) {
            for (const key of model.value) {
                if (newSelection === undefined) {
                    newSelection = {};
                }

                newSelection[key] = {
                    checked: true,
                    partialChecked: false,
                };
            }
        }
    } else {
        if (model.value && !Array.isArray(model.value)) {
            if (newSelection === undefined) {
                newSelection = {};
            }

            newSelection[model.value] = true;
        }
    }
    selected.value = newSelection;
};

const onSelectionUpdated = (event: any) => {
    selected.value = event;

    if (props.multiple) {
        const newModel = [];

        for (const key in event) {
            if (event[key] && event[key].checked && !event[key].partialChecked) {
                if (typeof key === 'string' && Number.isNaN(Number(key))) {
                    newModel.push(key);
                } else {
                    newModel.push(+key);
                }
            }
        }

        model.value = newModel;
    } else {
        if (event) {
            for (const key in event) {
                if (event[key]) {
                    if (typeof key === 'string' && Number.isNaN(Number(key))) {
                        model.value = key;
                    } else {
                        model.value = +key;
                    }
                    break;
                }
            }
        } else {
            model.value = null;
        }
    }
};

setSelection();

watch(
    () => props.params,
    (newValue: any, oldValue: any) => {
        for (const key in props.params) {
            if (newValue[key] !== oldValue[key]) {
                model.value = null;
                onLoad();

                break;
            }
        }
    },
);

onMounted(async () => {
    onLoad();
});
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeTreeSelect
                :id="name"
                :model-value="selected"
                :name="name"
                :size="size"
                fluid
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :options="currentOptions"
                :show-clear="clearable"
                :filter="filter"
                :loading="loading"
                :filter-placeholder="filterPlaceholder ?? $t('avid::form.write_to_search')"
                :selection-mode="selectionMode"
                :display="multiple ? 'chip' : undefined"
                :maxSelectedLabels="5"
                :selected-items-label="Array.isArray(model) ? `${model.length} elementi selezionati` : ''"
                :pt="{
                    label: 'flex-wrap',
                }"
                @update:model-value="onSelectionUpdated"
            >
                <template v-if="$slots.header || header" #header>
                    <template v-if="$slots.header">
                        <slot name="header"></slot>
                    </template>

                    <template v-else-if="header">
                        <template v-if="isHeaderRaw">
                            <div v-html="header"></div>
                        </template>
                        <template v-else>
                            <div class="px-3 py-2 font-medium">{{ header }}</div>
                        </template>
                    </template>
                </template>

                <template v-if="$slots.footer || footer" #footer>
                    <template v-if="$slots.footer">
                        <slot name="footer"></slot>
                    </template>

                    <template v-else>
                        <template v-if="isFooterRaw">
                            <div v-html="footer"></div>
                        </template>
                        <template v-else>
                            <div class="px-3 py-2 font-medium">{{ footer }}</div>
                        </template>
                    </template>
                </template>

                <template #empty> Nessun risultato trovato </template>
            </PrimeTreeSelect>
        </template>
    </FormControl>
</template>
