export interface Paginate<Type> {
    data: Type[];
    meta: PaginateMeta;
    links: {
        first: string | null;
        last: string | null;
        next: string | null;
        prev: string | null;
    };
}

export interface PaginateLink {
    active?: boolean;
    label?: string;
    url?: string;
}

export interface PaginateMeta {
    current_page: number;
    from: number;
    last_page: number;
    links: PaginateLink[];
    path: string;
    per_page: number;
    to: number;
    total: number;
}
