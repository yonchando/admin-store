import { ColumnType } from "@/types/datatable/column";
import { Category } from "@/types/models/category";
import { globalFilter } from "@/services/helper.service";
import axios, { AxiosResponse } from "axios";
import { Paginate } from "@/types/paginate";

export const columns: ColumnType<Category>[] = [
    {
        label: "Name",
        field: "category_name",
        sortable: "category_name",
    },
    {
        label: "Created date",
        field: "created_at",
        sortable: "created_at",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Updated date",
        field: "updated_at",
        sortable: "updated_at",
        props: {
            class: "w-48",
        },
    },
];

export const filters = {
    ...globalFilter,
};

export interface CategoryFilter {
    page?: number;
    search?: string;
    perPage?: number;
}

export function getCategories(options: CategoryFilter = {}): Promise<AxiosResponse<Paginate<Category>>> {
    options = { page: 1, perPage: 25, ...options };
    return axios.get(
        route("category.index", {
            perPage: options.perPage,
            includes: ["children"],
            page: options.page ?? "",
            search: options.search ?? "",
        }),
    );
}

export default {
    columns,
    filters,
    getCategories,
};
