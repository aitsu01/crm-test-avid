<script setup lang="ts">
import { Filter } from '@/avid/types/table';

const props = defineProps<{
    filter: Filter;
}>();

const emit = defineEmits<{
    (e: 'filter'): void;
}>();

const filtersForm = defineModel<any>('filtersForm');
const operatorsForm = defineModel<any>('operatorsForm');

const operator = ref<string>(operatorsForm.value[props.filter.name] ?? (props.filter.clauses.length ? props.filter.clauses[0].key : ''));

const menu = ref();

const items = computed(() => {
    return props.filter.clauses
        .filter((clause) => !['between', 'not_between'].includes(clause.key))
        .map((clause) => {
        return {
            label: clause.label,
            class: operator.value === clause.key ? 'active' : '',
            command: () => {
                operator.value = clause.key;

                if (filtersForm.value[props.filter.name]) {
                    onFilter();
                }
            },
        };
    });
});

const componentsMap: any = {
    FilterText: defineAsyncComponent(() => import('./elements/FilterText.vue')),
    FilterNumber: defineAsyncComponent(() => import('./elements/FilterNumber.vue')),
    FilterDate: defineAsyncComponent(() => import('./elements/FilterDate.vue')),
    FilterBoolean: defineAsyncComponent(() => import('./elements/FilterBoolean.vue')),
    FilterSelect: defineAsyncComponent(() => import('./elements/FilterSelect.vue')),
    FilterTree: defineAsyncComponent(() => import('./elements/FilterTree.vue')),
};

const componentName = computed(() => {
    return componentsMap[props.filter.component] ?? null;
});

const onToggle = (event: any) => {
    menu.value.toggle(event);
};

const onFilter = () => {
    if (filtersForm.value[props.filter.name] === undefined || filtersForm.value[props.filter.name] === null) {
        filtersForm.value[props.filter.name] = undefined;
        operatorsForm.value[props.filter.name] = undefined;
    } else {
        operatorsForm.value[props.filter.name] = operator.value;
    }

    emit('filter');
};
</script>

<template>
    <div class="grid min-w-[150px] grid-cols-[1fr_30px] items-center gap-1">
        <div class="min-w-0">
            <component
                :is="componentName"
                v-model="filtersForm[filter.name]"
                v-bind="filter.props"
                :name="filter.name"
                :label="filter.label"
                :clause="operator"
                size="small"
                @filter="onFilter"
            />
        </div>

        <PrimeButton v-if="items.length > 1" icon="pi pi-filter" variant="text" class="!px-1 !py-1" severity="contrast" @click="onToggle" />

        <PrimeMenu ref="menu" :model="items" :popup="true" />
    </div>
</template>
