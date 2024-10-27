import { Column } from "@/types/datatable/column";

export const columns: Column[] = [
    {
        label: "Name",
        field: "category_name",
        sortable: true,
    },
    {
        label: "Created date",
        field: "created_at",
        sortable: true,
        props: {
            class: "w-48",
        },
    },
    {
        label: "Updated date",
        field: "updated_at",
        sortable: true,
        props: {
            class: "w-48",
        },
    },
];

export const filters = {
    page: 1,
    sortable: {
        field: "created_at",
        direction: "desc",
    },
    search: "",
};

export default {
    columns,
    filters,
};
