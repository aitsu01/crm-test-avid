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
import { visitModal } from '@inertiaui/modal-vue'

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
    CanCreateRecord {
    editable?: boolean;
}

const props = defineProps<Props>();

const emit = defineEmits<{
    (e: 'select', option: Option): void;
}>()

const model = defineModel<string | number | null | undefined>();

const search = ref<string | undefined>();
const filterInput = ref<VNodeRef | undefined>(undefined);
const selectElement = ref<VNodeRef | undefined>(undefined);

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

const onCloseOverlay = () => {
    if (selectElement.value) {
        selectElement.value.hide();
    }
};

const onClear = () => {
    search.value = undefined;
    onLoad();
};

const onSelectOption = (key: string | number) => {
    model.value = key;

    if (!key || !currentOptions.value) {
        return null;
    }

    const current = currentOptions.value.find((option: Option) => option.key === key)

    if (current) {
        emit('select', current);
    }
}

const onCreateRecord = () => {
    onCloseOverlay();

    visitModal(props.createRecordUrl, {
        onClose: () => onLoad(),
    });
}

watch(
    () => props.params,
    () => {
        model.value = null;
        onLoad();
    },
);

onMounted(async () => {
    onLoad();
});
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeSelect :id="name" ref="selectElement" :model-value="model" :name="name" :size="size" fluid
                :placeholder="placeholder" :disabled="disabled" :readonly="readonly" :invalid="invalid"
                :options="currentOptions" option-label="label" option-value="key"
                :virtual-scroller-options="virtualScollerOptions" :editable="editable" :show-clear="clearable"
                :filter="filter && !async" :loading="loading"
                :filter-placeholder="filterPlaceholder ?? $t('avid::form.write_to_search')" @focus="onFocus"
                @update:model-value="onSelectOption">
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
                                <PrimeInputText v-model="search" ref="filterInput" fluid
                                    :placeholder="filterPlaceholder ?? $t('avid::form.write_to_search')"
                                    @value-change="onFilter" />

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
                            <PrimeButton :label="createRecordLabel" fluid severity="secondary" variant="outlined"
                                @click="onCreateRecord" />
                        </div>
                    </template>
                </template>

                <template #empty> {{ $t('avid::form.no_results_found') }} </template>
            </PrimeSelect>
        </template>
    </FormControl>
</template>
