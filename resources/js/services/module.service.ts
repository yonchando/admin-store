import { Column } from "@/types/datatable/column";
import { Module } from "@/types/models/module";
import Badge from "@/Components/Badges/Badge.vue";
import { globalFilter } from "@/services/helper.service";

export const columns: Column<Module>[] = [
    {
        label: "Name",
        field: "name",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Status",
        field: "status_text",
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
            class: "w-12",
        },
    },
    {
        label: "Updated date",
        field: "updated_at",
        props: {
            class: "w-12",
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
