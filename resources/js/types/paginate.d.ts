export interface PaginateLink {
    active?: boolean;
    label?: string;
    url?: string;
    first?: string;
    last?: string;
    next?: string;
    prev?: string;
}

export interface Paginate<Type> {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: PaginateLink[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
    data: Type[];
}
