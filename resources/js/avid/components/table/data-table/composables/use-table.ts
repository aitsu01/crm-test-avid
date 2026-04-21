import { Table } from '@/avid/types/table';
import { useDebounceFn } from '@vueuse/core';
import { DataTablePageEvent, DataTableSortEvent } from 'primevue/datatable';

export function useTable(table: Table) {
    const loading = ref(false);
    const selection = ref<any[]>([]);

    const params = ref<any>({
        per_page: table.records.meta?.per_page,
        page: table.records.meta?.current_page ?? 1,
        sort: (() => {
            if (table.sort.direction === 1) {
                return table.sort.column;
            } else if (table.sort.direction === -1) {
                return '-' + table.sort.column;
            } else {
                return undefined;
            }
        })(),
        filter: table.filters.query.filter ?? {},
        operator: table.filters.query.operator ?? {},
    });

    const loadLazyData = () => {
        selection.value = [];
        if (params.value.per_page === table.pagination.defaultPageOption) {
            params.value.per_page = undefined;
        }

        loading.value = true;
        router.get(
            table.records.meta.path,
            { ...params.value },
            {
                preserveState: true,
            },
        );
    };

    const onPage = (event: DataTablePageEvent) => {
        params.value.page = event.page + 1;
        params.value.per_page = event.rows;
        loadLazyData();
    };

    const onSort = (event: DataTableSortEvent) => {
        params.value.page = 1;

        if (event.sortOrder === 1) {
            params.value.sort = event.sortField;
        } else if (event.sortOrder === -1) {
            params.value.sort = '-' + event.sortField;
        } else {
            params.value.sort = undefined;
        }

        loadLazyData();
    };

    const onFilter = useDebounceFn(() => {
        params.value.page = 1;
        loadLazyData();
    }, 500);

    const onClearFilter = () => {
        params.value.page = 1;
        params.value.filter = {};
        params.value.operator = {};
        onFilter();
    };

    const onClearSelection = () => {
        selection.value = [];
    };

    const filterDisplay = computed<any>(() => {
        if (!table.search.isSearchableByColumn) {
            return null;
        }

        return 'row';
    });

    const showHeader = computed(() => {
        return table.search.isSearchable || table.filters.schema.length || table.bulkActions.length;
    });

    const showSelection = computed(() => {
        return table.bulkActions.filter((bulkAction) => {
            if (Object.hasOwn(bulkAction, 'method')) {
                return bulkAction.method !== 'get';
            } else if (Object.hasOwn(bulkAction, 'actions')) {
                return bulkAction.actions.filter((action: any) => action.method !== 'get').length;
            }
            return false;
        }).length;
    })

    const selectionIds = computed(() => {
        return selection.value.map((item: any) => item.tableDataKey);
    });

    const filtersAppliedCount = computed(() => {
        let count = 0;
        for (const key in params.value.filter) {
            if (params.value.filter[key] !== null && params.value.filter[key] !== undefined && params.value.filter[key] !== '') {
                count++;
            }
        }
        return count;
    });

    return {
        loading,
        selection,
        selectionIds,
        params,
        onPage,
        onSort,
        onFilter,
        onClearFilter,
        onClearSelection,
        loadLazyData,
        filterDisplay,
        showHeader,
        showSelection,
        filtersAppliedCount,
    };
}
