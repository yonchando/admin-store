import { router } from "@inertiajs/vue3";
import Badge from "primevue/badge";

export default {
    columns: [
        {
            header: "Name",
            field: "product_name",
            sortable: true,
            'class': 'w-1/3'
        },
        {
            header: "Category Name",
            field: "category.category_name",
            class: "w-64",
        },
        {
            header: "price",
            field: "price",
            class: "w-52",
        },
        {
            header: "Stock",
            field: "stock_quantity",
        },
        {
            header: "Status",
            field: "status",
            'class': 'w-24',
            component: Badge,
            props: (e) => {
                return {
                    value: e.data.status_text.text,
                    severity: e.data.status_text.severity,
                }
            }
        },
    ],
    create: () => {
        return router.get(route("product.create"));
    },
    update: (id) => {
        return router.get(route("product.edit", id));
    },
    refresh: () => {
        router.reload();
    },
};
