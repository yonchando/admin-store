export interface Filters {
    perPage: number;
    page: number;
    sortBy: {
        field: any;
        direction: "asc" | "desc" | "-1";
    };
}
