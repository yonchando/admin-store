import { Column } from "@/types/datatable/column";
import Badge from "@/Components/Badges/Badge.vue";
import { Product } from "@/types/models/product";
import { globalFilter } from "@/services/helper.service";

export const columns: Column<Product>[] = [
    {
        label: "Name",
        field: "product_name",
        sortable: "product_name",
        props: {},
    },
    {
        label: "Category",
        field: (p) => {
            return p.category?.category_name;
        },
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
        component: {
            el: Badge,
            props: (item: Product) => {
                return {
                    severity: item.status == "active" ? "info" : "error",
                };
            },
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
    price: null,
    status: null,
    category: null,
};

export const status = {
    active: "success",
    inactive: "error",
};

export default {
    columns,
    filters,
};
