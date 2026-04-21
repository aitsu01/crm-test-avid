<script setup lang="ts">
import { useDebounceFn } from '@vueuse/core';
import axios from 'axios';
import type { VNodeRef } from 'vue';

export interface Option {
    key: any;
    label: string;
}

interface Props {
    name: string;
    label?: string;
    clause?: string;
    options?: Option[];
    virtualScroll?: number;
    async?: string;
    filter?: boolean;
    filterPlaceholder?: string;
}

const props = withDefaults(defineProps<Props>(), {});

const emit = defineEmits<{
    (e: 'filter'): void;
}>();

const model = defineModel<string | number | (string | number)[] | null | undefined>();

const search = ref<string | undefined>();
const filterInput = ref<VNodeRef | undefined>(undefined);
const loading = ref(false);
const asyncOptions = ref<Option[]>([]);

const selectionMode = computed(() => {
    if (!props.clause) {
        return undefined;
    }

    if (['in', 'not_in'].includes(props.clause)) return 'multiple';

    return undefined;
});

const currentOptions = computed(() => {
    if (props.async) {
        return asyncOptions.value;
    } else {
        return props.options;
    }
});

const virtualScollerOptions = computed(() => {
    if (!props.virtualScroll) return undefined;

    return {
        itemSize: props.virtualScroll,
    };
});

const onLoad = useDebounceFn(async () => {
    if (!props.async) return;

    loading.value = true;

    const { data } = await axios.get(props.async, {
        params: {
            search: search.value,
            current: model.value,
        },
    });

    asyncOptions.value = data;

    loading.value = false;
}, 300);

const onFilter = useDebounceFn(() => {
    onLoad();
}, 300);

const onFocus = () => {
    setTimeout(() => {
        if (filterInput.value) {
            filterInput.value.$el.focus();
        }
    }, 500);
};

const onClear = () => {
    search.value = undefined;
    onLoad();
};

onMounted(async () => {
    onLoad();
});

watch(selectionMode, (value) => {
    if (value === 'multiple') {
        model.value = [];
    } else {
        model.value = null;
    }
});
</script>

<template>
    <template v-if="selectionMode === 'multiple' && Array.isArray(model)">
        <PrimeMultiSelect
            :id="name"
            v-model="model"
            :name="name"
            :options="currentOptions"
            option-label="label"
            option-value="key"
            :virtual-scroller-options="virtualScollerOptions"
            :filter="filter && !async"
            :loading="loading"
            :filter-placeholder="filterPlaceholder"
            display="chip"
            fluid
            :max-selected-labels="5"
            :selected-items-label="`${model.length} elementi selezionati`"
            :pt="{
                label: 'flex-wrap',
            }"
            @focus="onFocus"
            @change="emit('filter')"
        >
            <template v-if="async" #header>
                <template v-if="async && filter">
                    <div class="px-3 py-3">
                        <PrimeIconField>
                            <PrimeInputText v-model="search" ref="filterInput" fluid :placeholder="filterPlaceholder" @value-change="onFilter" />

                            <PrimeInputIcon v-if="loading" class="cursor-pointer" @click="onClear">
                                <i class="pi pi-spin pi-spinner" />
                            </PrimeInputIcon>

                            <PrimeInputIcon v-else-if="search" class="cursor-pointer" @click="onClear">
                                <i class="pi pi-times" />
                            </PrimeInputIcon>

                            <PrimeInputIcon v-else>
                                <i class="pi pi-search" />
                            </PrimeInputIcon>
                        </PrimeIconField>
                    </div>
                </template>

                <PrimeProgressBar v-if="loading" mode="indeterminate" style="height: 3px" />
                <div v-else style="height: 3px"></div>
            </template>

            <template #empty> Nessun risultato trovato </template>
        </PrimeMultiSelect>
    </template>

    <template v-else>
        <PrimeSelect
            :id="name"
            v-model="model"
            :name="name"
            fluid
            :options="currentOptions"
            option-label="label"
            option-value="key"
            :virtual-scroller-options="virtualScollerOptions"
            show-clear
            :filter="filter && !async"
            :loading="loading"
            :filter-placeholder="filterPlaceholder"
            @focus="onFocus"
            @change="emit('filter')"
        >
            <template v-if="async" #header>
                <template v-if="async && filter">
                    <div class="px-3 py-3">
                        <PrimeIconField>
                            <PrimeInputText v-model="search" ref="filterInput" fluid :placeholder="filterPlaceholder" @value-change="onFilter" />

                            <PrimeInputIcon v-if="loading" class="cursor-pointer" @click="onClear">
                                <i class="pi pi-spin pi-spinner" />
                            </PrimeInputIcon>

                            <PrimeInputIcon v-else-if="search" class="cursor-pointer" @click="onClear">
                                <i class="pi pi-times" />
                            </PrimeInputIcon>

                            <PrimeInputIcon v-else>
                                <i class="pi pi-search" />
                            </PrimeInputIcon>
                        </PrimeIconField>
                    </div>
                </template>

                <PrimeProgressBar v-if="loading" mode="indeterminate" style="height: 3px" />
                <div v-else style="height: 3px"></div>
            </template>

            <template #empty> Nessun risultato trovato </template>
        </PrimeSelect>
    </template>
</template>
