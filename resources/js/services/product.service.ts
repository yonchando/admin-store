import { ColumnType } from "@/types/datatable/column";
import Badge from "@/Components/Badges/Badge.vue";
import { Product } from "@/types/models/product";
import { globalFilter } from "@/services/helper.service";
import { defineStore } from "pinia";
import { Paginate } from "@/types/paginate";
import axios from "axios";
import { currency } from "@/number_format";

export const columns: ColumnType<Product>[] = [
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
        field: (p) => currency(p.price, true),
        sortable: "price",
        props: {
            class: "w-32",
        },
    },
    {
        label: "Stock qty",
        field: "stock_qty",
        sortable: "stock_qty",
        props: {
            class: "w-40",
        },
        component: {
            el: Badge,
            props: {
                severity: "info",
            },
        },
    },
    {
        label: "Status",
        field: (p) => __(p.status),
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
        hideFromIndex: true,
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

export const useProductStore = defineStore("product", {
    state: () => {
        return {
            data: [] as Product[],
            paginate: {} as Paginate<Product>,
        };
    },
    actions: {
        getData(filters: any = {}) {
            axios.get(route("product.index", filters)).then((res) => {
                this.data = res.data.data;
            });
        },
        search(filters: any = {}) {
            this.getData(filters);
        },
    },
});
