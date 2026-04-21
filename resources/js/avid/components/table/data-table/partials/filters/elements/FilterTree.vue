<script setup lang="ts">
import { useDebounceFn } from '@vueuse/core';
import axios from 'axios';

export interface Option {
    key: any;
    label: string;
}

interface Props {
    name: string;
    label?: string;
    clause?: string;
    options?: Option[];
    async?: string;
    filter?: boolean;
    filterPlaceholder?: string;
}

const props = withDefaults(defineProps<Props>(), {});

const emit = defineEmits<{
    (e: 'filter'): void;
}>();

const model = defineModel<string | number | (string | number)[] | null | undefined>();

const selected = ref<any>(undefined);

const search = ref<string | undefined>();
const loading = ref(false);
const asyncOptions = ref<Option[]>([]);

const selectionMode = computed(() => {
    if (!props.clause) {
        return undefined;
    }

    if (['in', 'not_in'].includes(props.clause)) return 'checkbox';

    return undefined;
});

const currentOptions = computed(() => {
    if (props.async) {
        return asyncOptions.value ?? [];
    } else {
        return props.options ?? [];
    }
});

const onLoad = useDebounceFn(async () => {
    if (!props.async) return;

    loading.value = true;

    const { data } = await axios.get(props.async, {
        params: {
            search: search.value,
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

    if (selectionMode.value === 'checkbox') {
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
    emit('filter');
};

onMounted(async () => {
    await onLoad();

    setSelection();
});

watch(selectionMode, (value) => {
    if (value === 'checkbox') {
        model.value = [];
        selected.value = undefined;
    } else {
        model.value = null;
        selected.value = undefined;
    }
});
</script>

<template>
    <PrimeTreeSelect
        :id="name"
        :model-value="selected"
        :name="name"
        fluid
        :options="currentOptions"
        show-clear
        :filter="filter"
        :loading="loading"
        :filter-placeholder="filterPlaceholder"
        :selection-mode="selectionMode"
        :display="selectionMode === 'checkbox' ? 'chip' : undefined"
        :maxSelectedLabels="5"
        :selected-items-label="Array.isArray(model) ? `${model.length} elementi selezionati` : ''"
        :pt="{
            label: 'flex-wrap',
        }"
        @update:model-value="onSelectionUpdated"
    >
        <template #empty> Nessun risultato trovato </template>
    </PrimeTreeSelect>
</template>
