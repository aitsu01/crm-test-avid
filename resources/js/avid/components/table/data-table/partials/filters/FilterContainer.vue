<script setup lang="ts">
import { Filter, Table } from '@/avid/types/table';
import FilterElement from './elements/FilterElement.vue';

const props = defineProps<{
    table: Table;
}>();

const emit = defineEmits<{
    (e: 'filter'): void;
    (e: 'clear'): void;
}>();

const filtersForm = defineModel<any>('filtersForm');
const operatorsForm = defineModel<any>('operatorsForm');

const isOpen = defineModel<boolean>('isOpen');

const selectedFilters = ref<Filter[]>([]);

const popover = ref();

const onRemoveFilter = (filter: Filter) => {
    selectedFilters.value = selectedFilters.value.filter((f) => f.name !== filter.name);

    delete filtersForm.value[filter.name];
    delete operatorsForm.value[filter.name];
};

const onResetFilters = () => {
    selectedFilters.value = [];
    emit('clear');
};

const items = computed(() => {
    return props.table.filters.schema.map((filter) => {
        const i = selectedFilters.value.findIndex((f) => f.name === filter.name);

        return {
            label: filter.label,
            icon: i > -1 ? 'pi pi-minus' : 'pi pi-plus',
            selected: i > -1,
            command: () => {
                if (i > -1) {
                    onRemoveFilter(filter);
                } else {
                    selectedFilters.value.push(filter);

                    filtersForm.value[filter.name] = null;
                    operatorsForm.value[filter.name] = filter.clauses.length ? filter.clauses[0].key : null;
                }
            },
        };
    });
});

const onToggle = (event: any) => {
    popover.value.toggle(event);
};

const componentsMap: any = {
    collapse: defineAsyncComponent(() => import('./layouts/CollapseLayout.vue')),
    drawer: defineAsyncComponent(() => import('./layouts/DrawerLayout.vue')),
};

const componentName = computed(() => {
    return componentsMap[props.table.filters.layout] ?? null;
});

onMounted(() => {
    props.table.filters.schema.forEach((filter: Filter) => {
        if (filtersForm.value[filter.name] || operatorsForm.value[filter.name]) {
            selectedFilters.value.push(filter);
        }
    });
});
</script>

<template>
    <div>
        <component :is="componentName" v-model:is-open="isOpen" @filter="emit('filter')" @clear="onResetFilters">
            <template #button>
                <div class="flex justify-center">
                    <PrimeButton
                        :label="$t('avid::table.filters.add_filter')"
                        variant="outlined"
                        icon="pi pi-plus"
                        severity="secondary"
                        @click="onToggle"
                    />

                    <PrimePopover ref="popover">
                        <div
                            :class="{
                                'grid grid-cols-2 gap-x-2 gap-y-1': items.length > 4,
                            }"
                        >
                            <template v-for="item in items" :key="item.label">
                                <PrimeButton
                                    :label="item.label"
                                    :icon="item.icon"
                                    :severity="item.selected ? 'primary' : 'secondary'"
                                    variant="text"
                                    size="small"
                                    class="!justify-start"
                                    @click="item.command"
                                />
                            </template>
                        </div>
                    </PrimePopover>
                </div>
            </template>

            <template v-for="filter in selectedFilters" :key="filter.name">
                <FilterElement
                    v-model:filters-form="filtersForm"
                    v-model:operators-form="operatorsForm"
                    :filter="filter"
                    @remove="onRemoveFilter(filter)"
                />
            </template>
        </component>
    </div>
</template>
