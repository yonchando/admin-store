export interface Filters {
    perPage: number;
    page: number;
    sortBy: {
        field: any;
        direction: "asc" | "desc" | "-1";
    };
    [key: string]: any;
}

export interface FilterData {
    [key: string]: any;
}
