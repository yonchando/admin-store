import { ColumnType } from "@/types/datatable/column";
import { Category } from "@/types/models/category";
import { globalFilter } from "@/services/helper.service";

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

export default {
    columns,
    filters,
};
