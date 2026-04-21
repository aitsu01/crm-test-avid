<script setup lang="ts">
import {
    CanCreateRecord,
    Field,
    HasAsync,
    HasClearable,
    HasFilter,
    HasFooter,
    HasHeader,
    HasOptions,
    HasPlaceholder,
    HasSize,
    HasTemplateOption,
    HasVirtualScroll,
    Option,
} from '@/avid/types/form';
import { useDebounceFn } from '@vueuse/core';
import axios from 'axios';
import type { VNodeRef } from 'vue';
import FormControl from './FormControl.vue';

interface Props
    extends Field,
        HasSize,
        HasPlaceholder,
        HasOptions,
        HasHeader,
        HasFooter,
        HasVirtualScroll,
        HasClearable,
        HasAsync,
        HasFilter,
        HasTemplateOption,
        CanCreateRecord {}

const props = defineProps<Props>();

const model = defineModel<(string | number)[] | null | undefined>();

const search = ref<string | undefined>();
const filterInput = ref<VNodeRef | undefined>(undefined);
const loading = ref(false);
const asyncOptions = ref<Option[]>([]);

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
            ...(props.params ?? {}),
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
            <PrimeMultiSelect
                :id="name"
                v-model="model"
                :name="name"
                :size="size"
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :options="currentOptions"
                option-label="label"
                option-value="key"
                :virtual-scroller-options="virtualScollerOptions"
                :show-clear="clearable"
                :filter="filter && !async"
                :loading="loading"
                :filter-placeholder="filterPlaceholder ?? $t('avid::form.write_to_search')"
                display="chip"
                :max-selected-labels="5"
                :pt="{
                    label: 'flex-wrap',
                }"
                :selected-items-label="`${model?.length} ${$t('avid::form.selected_items')}`"
                @focus="onFocus"
            >
                <template v-if="$slots.header || header || async" #header>
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

                    <template v-if="async && filter">
                        <div class="px-3 py-3">
                            <PrimeIconField>
                                <PrimeInputText v-model="search" ref="filterInput" fluid :placeholder="filterPlaceholder ?? $t('avid::form.write_to_search')" @value-change="onFilter" />

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

                <template v-if="$slots.option || templateOption" #option="{ option }">
                    <template v-if="$slots.option">
                        <slot name="option" :option="option"></slot>
                    </template>

                    <template v-else>
                        <div v-html="option.labelTemplate"></div>
                    </template>
                </template>

                <template v-if="$slots.footer || footer || createRecordUrl" #footer>
                    <template v-if="$slots.footer">
                        <slot name="footer"></slot>
                    </template>

                    <template v-else-if="footer">
                        <template v-if="isFooterRaw">
                            <div v-html="footer"></div>
                        </template>
                        <template v-else>
                            <div class="px-3 py-2 font-medium">{{ footer }}</div>
                        </template>
                    </template>

                    <template v-if="createRecordUrl">
                        <div class="px-3 py-2">
                            <ModalLink :href="createRecordUrl" #default="{ loading }" @click="onCloseOverlay">
                                <PrimeButton :label="createRecordLabel" fluid severity="secondary" variant="outlined" :loading="loading" />
                            </ModalLink>
                        </div>
                    </template>
                </template>

                <template #empty> {{ $t('avid::form.no_results_found') }} </template>
            </PrimeMultiSelect>
        </template>
    </FormControl>
</template>
