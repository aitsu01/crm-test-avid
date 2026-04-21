<script setup lang="ts">
import { Filter } from '@/avid/types/table';

const props = defineProps<{
    filter: Filter;
}>();

const emit = defineEmits<{
    (e: 'remove'): void;
}>();

const filtersForm = defineModel<any>('filtersForm');
const operatorsForm = defineModel<any>('operatorsForm');

const componentsMap: any = {
    FilterText: defineAsyncComponent(() => import('./FilterText.vue')),
    FilterNumber: defineAsyncComponent(() => import('./FilterNumber.vue')),
    FilterDate: defineAsyncComponent(() => import('./FilterDate.vue')),
    FilterBoolean: defineAsyncComponent(() => import('./FilterBoolean.vue')),
    FilterSelect: defineAsyncComponent(() => import('./FilterSelect.vue')),
    FilterTree: defineAsyncComponent(() => import('./FilterTree.vue')),
};

const componentName = computed(() => {
    return componentsMap[props.filter.component] ?? null;
});
</script>

<template>
    <div>
        <PrimeFieldset :legend="filter.label" class="!px-3 !pb-3">
            <template #legend>
                <div class="flex items-center gap-1">
                    <PrimeButton variant="text" class="!px-1 !py-1" icon="pi pi-trash" severity="danger" size="small" @click="emit('remove')" />

                    <p class="font-semibold">
                        {{ filter.label }}
                    </p>
                </div>
            </template>

            <div class="space-y-2">
                <div class="grid min-w-0 grid-cols-[30px_1fr] items-center gap-2">
                    <div class="text-center">
                        <i class="pi pi-filter w-9 flex-shrink-0 text-center"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <PrimeSelect
                            v-model="operatorsForm[filter.name]"
                            :options="filter.clauses"
                            fluid
                            option-label="label"
                            option-value="key"
                            :disabled="filter.clauses.length <= 1"
                        />
                    </div>
                </div>

                <div class="grid min-w-0 grid-cols-[30px_1fr] items-center gap-2">
                    <div class="text-center">
                        <i class="pi pi-search flex-shrink-0 text-center"></i>
                    </div>
                    <div class="min-w-0">
                        <component
                            :is="componentName"
                            v-model="filtersForm[filter.name]"
                            v-bind="filter.props"
                            :name="filter.name"
                            :label="filter.label"
                            :clause="operatorsForm[filter.name]"
                        />
                    </div>
                </div>
            </div>
        </PrimeFieldset>
    </div>
</template>
