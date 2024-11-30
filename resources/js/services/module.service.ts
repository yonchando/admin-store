import { ColumnType } from "@/types/datatable/column";
import { Module } from "@/types/models/module";
import Badge from "@/Components/Badges/Badge.vue";
import { globalFilter } from "@/services/helper.service";

export const columns: ColumnType<Module>[] = [
    {
        label: "Name",
        field: "name",
        sortable: "name",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Order No.",
        field: "order_column",
        sortable: "order_column",
        props: {
            class: "w-24",
        },
    },
    {
        label: "Status",
        field: (item) => __(item.status),
        component: {
            el: Badge,
            props: (item: Module) => {
                return {
                    severity: item.status === "active" ? "info" : "warning",
                };
            },
        },
        props: {
            class: "w-12",
        },
    },
    {
        label: "Created date",
        field: "created_at",
        props: {
            class: "w-24",
        },
    },
    {
        label: "Updated date",
        field: "updated_at",
        props: {
            class: "w-24",
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
