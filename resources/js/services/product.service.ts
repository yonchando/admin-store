import { Column } from "@/types/datatable/column";

export const columns: Column[] = [
    {
        label: "Name",
        field: "product_name",
        sortable: "product_name",
        props: {},
    },
    {
        label: "Category",
        field: "category.name",
        sortable: "category",
        props: {},
    },
    {
        label: "Price",
        field: "price",
        sortable: "price",
        props: {
            class: "w-28",
        },
    },
    {
        label: "Stock qty",
        field: "stock_qty",
        sortable: "stock_qty",
        props: {
            class: "w-40",
        },
    },
    {
        label: "Status",
        field: "status_text",
        props: {
            class: "w-28",
        },
    },
    {
        label: "Created date",
        field: "created_at",
        sortable: "created_at",
        props: {
            class: "w-48",
        },
    },
];

export const filters = {
    search: "",
    sortBy: {
        field: "created_at",
        direction: "desc",
    },
    price: null,
    status: null,
    category: null,
    page: 1,
};

export default {
    columns,
    filters,
};
