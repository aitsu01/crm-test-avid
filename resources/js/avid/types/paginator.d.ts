export interface Paginator {
    data: any[];
    meta: PaginatorMeta;
}
interface PaginatorLink {
    url: string | null | undefined;
    label: string;
    active: boolean;
}
interface PaginatorMeta {
    current_page: number;
    first_page_url: string;
    from: number | null;
    last_page: number;
    last_page_url: string;
    next_page_url: string | null | undefined;
    path: string;
    per_page: number;
    prev_page_url: string | null | undefined;
    to: number | null;
    total: number;
    links?: PaginatorLink[];
}
