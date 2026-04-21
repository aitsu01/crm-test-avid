import { Paginator } from './paginator';

export interface Column {
    component: string;
    name: string;
    sortable: boolean;
    label?: string;
    width?: string;
    alignment?: string;
    placeholder?: string;
    isSearchable?: boolean;
    filter?: Filter;
}

export interface Action {
    component: string;
    name: string;
    label?: string;
    color?: any;
    icon?: string;
    method: 'get' | 'post' | 'put' | 'delete';
    url?: string;
    requiresConfirmation?: boolean;
    confirmationMessage?: string;
    shouldOpenUrlInNewTab?: boolean;
    shouldOpenUrlInModal?: boolean;
    showLabel?: boolean;
    disabled?: boolean;
    modalSize?: 'sm' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl' | '5xl' | '6xl';
}

export interface ActionGroup {
    component: string;
    icon?: string;
    label?: string;
    showLabel?: boolean;
    actions: Action[];
}

export interface Filter {
    name: string;
    label: string;
    component: string;
    props: any;
    clauses: {
        key: any;
        label: string;
    }[];
    defaultClause: string;
}

export interface Table {
    columns: Column[];
    records: Paginator;
    sort: {
        column: string | null;
        direction: number | null;
    };
    pagination: {
        isPaginated: boolean;
        pageOptions: number[];
        defaultPageOption: number | null;
    };
    search: {
        isSearchable: boolean;
        isSearchableByColumn: boolean;
        placeholder: string | null;
    };
    empty: {
        icon: string;
        heading: string;
        description?: string;
    };
    bulkActions: (Action | ActionGroup)[];
    size?: 'small' | 'large';
    filters: {
        layout: 'collapse' | 'drawer';
        query: {
            filter: any;
            operator: any;
        };
        schema: Filter[];
    };
}
