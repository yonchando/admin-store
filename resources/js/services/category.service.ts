import { Column } from "@/types/datatable/column";

export const columns: Column[] = [
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
    page: 1,
    sortBy: {
        field: "created_at",
        direction: "desc",
    },
    search: "",
};

export default {
    columns,
    filters,
};
