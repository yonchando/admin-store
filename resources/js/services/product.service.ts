import { ColumnType } from "@/types/datatable/column";
import Badge from "@/Components/Badges/Badge.vue";
import { Product, ProductFilter } from "@/types/models/product";
import { globalFilter } from "@/services/helper.service";
import { currency } from "@/number_format";
import Select from "@/Components/Forms/Select.vue";
import axios from "axios";

export const columns: ColumnType<Product>[] = [
    {
        label: "Name",
        field: "product_name",
        sortable: "product_name",
    },
    {
        label: "Category",
        field: (p) => {
            return p.category?.category_name;
        },
        sortable: "category",
        filters: {
            field: "category",
            component: {
                el: Select,
                props: (props: any) => {
                    return {
                        options: props.filtersData?.categories.data,
                        optionValue: "id",
                        optionLabel: "category_name",
                    };
                },
            },
        },
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
                severity: "warning",
            },
        },
    },
    {
        label: "Status",
        field: (p) => __(p.status),
        props: {
            class: "w-28",
        },
        filters: {
            field: "status",
            component: {
                el: Select,
                props: (props: any) => {
                    return {
                        options: props.filtersData?.statuses ?? [],
                    };
                },
            },
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

export class ProductService {
    static getData(filters: ProductFilter) {
        return;
    }
}
