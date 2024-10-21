import { Column } from "@/types/datatable/column";
import { Category } from "@/types/models/category";

export const columns: Column<Category>[] = [
    {
        label: "Name",
        field: "category_name",
    },
    {
        label: "Created date",
        field: "created_at",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Updated date",
        field: "updated_at",
        props: {
            class: "w-48",
        },
    },
];

export default {
    columns,
};
