export interface Paginate<Type> {
    data: Type[];
    meta: PaginateMeta;
    links: {
        first: string;
        last: string;
        next: string;
        prev: string;
    };
}

export interface PaginateLink {
    active?: boolean;
    label?: string;
    url?: string;
}

export interface PaginateMeta {
    current_page: number | null;
    from: number | null;
    last_page: number | null;
    links: PaginateLink[] | null;
    path: string | null;
    per_page: number | null;
    to: number | null;
    total: number | null;
}
