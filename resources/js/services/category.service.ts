import { Column } from "@/types/datatable/column";

export const columns: Column[] = [
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
