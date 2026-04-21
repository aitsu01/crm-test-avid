<script setup lang="ts">
import { Table as TableType } from '@/avid/types/table';
import { useTable } from './composables/use-table';
import { ActionElement, BlukActionElement, ColumnElement, ColumnFilterElement, FilterContainer } from './partials';

const props = defineProps<{
    table: TableType;
}>();

const emit = defineEmits<{
    (e: 'action', action: string, data: any): void;
}>();

const { selection, selectionIds, params, onPage, onSort, onFilter, onClearFilter, onClearSelection, filterDisplay, showHeader, filtersAppliedCount, showSelection } =
    useTable(props.table);

const columns = ref([...props.table.columns]);
const bulkActions = ref([...props.table.bulkActions]);

const isFilterOpen = ref(false);
</script>

<template>
    <div>
        <PrimeDataTable
            v-model:selection="selection"
            data-key="tableDataKey"
            lazy
            :paginator="table.pagination.isPaginated"
            :value="table.records.data"
            :rows="table.records.meta?.per_page ?? 10"
            :first="table.records.meta?.from ?? undefined"
            :total-records="table.records.meta?.total"
            :rows-per-page-options="table.pagination.pageOptions"
            :sort-field="table.sort.column ?? undefined"
            :sort-order="table.sort.direction ?? undefined"
            removable-sort
            scrollable
            paginatorTemplate="
                CurrentPageReport
                FirstPageLink
                PrevPageLink
                PageLinks
                NextPageLink
                LastPageLink
                RowsPerPageDropdown
            "
            :currentPageReportTemplate="`${$t('avid::table.from')} {first} ${$t('avid::table.to')} {last} ${$t('avid::table.of')} {totalRecords}`"
            :pt="{
                root: 'rounded-lg',
                header: '!p-0 rounded-t-lg',
                bodyROw: 'group',
                column: {
                    bodyCell: 'p-0 group-hover:bg-gray-50 dark:group-hover:bg-gray-800',
                },
            }"
            :filter-display="filterDisplay"
            :size="table.size"
            @page="onPage"
            @sort="onSort"
        >
            <template #header>
                <div v-if="showHeader" class="flex flex-col justify-between gap-4 p-4 md:flex-row">
                    <div class="flex flex-wrap gap-2">
                        <template v-for="(action, i) in bulkActions" :key="i">
                            <BlukActionElement :action="action" :size="table.size" :selection="selectionIds" />
                        </template>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <PrimeIconField v-if="table.search.isSearchable">
                            <PrimeInputIcon>
                                <i class="pi pi-search" />
                            </PrimeInputIcon>

                            <PrimeInputText
                                v-model="params.filter.search"
                                :placeholder="table.search.placeholder ?? ''"
                                @keyup.enter="onFilter"
                                @input="onFilter"
                            />
                        </PrimeIconField>

                        <template v-if="table.filters.schema.length">
                            <PrimeOverlayBadge v-if="filtersAppliedCount" :value="filtersAppliedCount">
                                <PrimeButton icon="pi pi-filter" @click="isFilterOpen = !isFilterOpen" />
                            </PrimeOverlayBadge>

                            <PrimeButton v-else icon="pi pi-filter" @click="isFilterOpen = !isFilterOpen" />
                        </template>
                    </div>
                </div>

                <FilterContainer
                    v-if="table.filters.schema.length"
                    v-model:is-open="isFilterOpen"
                    v-model:filters-form="params.filter"
                    v-model:operators-form="params.operator"
                    :table="table"
                    @filter="onFilter"
                    @clear="onClearFilter"
                />

                <div v-if="selection.length" class="flex items-center justify-between border-t px-4 py-1">
                    <p class="font-medium">{{ selection.length }} {{ $t('avid::table.selected') }}</p>

                    <PrimeButton :label="$t('avid::table.deselect_all')" severity="danger" variant="text" size="small" @click="onClearSelection" />
                </div>
            </template>

            <PrimeColumn v-if="showSelection" selectionMode="multiple" headerStyle="width: 3rem" frozen></PrimeColumn>

            <template v-for="(column, i) in columns" :key="i">
                <PrimeColumn
                    :field="column.name"
                    :header="column.label"
                    :sortable="column.sortable"
                    :style="{
                        width: column.width ?? undefined,
                        textAlign: column.alignment ?? undefined,
                    }"
                    :showFilterMenu="false"
                >
                    <template #body="{ data }">
                        <ColumnElement :column="column" :data="data" :size="table.size" />
                    </template>

                    <template v-if="column.isSearchable && column.filter" #filter>
                        <ColumnFilterElement
                            v-model:filters-form="params.filter"
                            v-model:operators-form="params.operator"
                            :filter="column.filter"
                            @filter="onFilter"
                        />
                    </template>
                </PrimeColumn>
            </template>

            <PrimeColumn frozen align-frozen="right">
                <template #body="{ data }">
                    <div class="flex justify-end gap-1 px-2">
                        <template v-for="(action, i) in data.actions" :key="i">
                            <ActionElement :action="action" :size="table.size" @action="emit('action', $event, data)" />
                        </template>
                    </div>
                </template>
            </PrimeColumn>

            <template #empty>
                <div class="flex flex-col items-center justify-center px-4 py-8">
                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-gray-50 text-gray-400 dark:bg-muted dark:text-gray-300"
                    >
                        <i class="text-2xl" :class="table.empty.icon"></i>
                    </div>

                    <p class="mb-1 font-semibold">
                        {{ table.empty.heading }}
                    </p>
                    <p v-if="table.empty.description" class="text-gray-500 dark:text-gray-300">
                        {{ table.empty.description }}
                    </p>
                </div>
            </template>
        </PrimeDataTable>
    </div>
</template>
