import { Column } from "@/types/datatable/column";
import { Module } from "@/types/models/module";
import Badge from "@/Components/Badges/Badge.vue";
import { globalFilter } from "@/services/helper.service";
import { Customer } from "@/types/models/customer";

export const columns: Column<Customer>[] = [
    {
        label: "Nickname",
        field: "nickname",
    },
    {
        label: "Email",
        field: "email",
    },
    {
        label: "Phone number",
        field: "phone_number",
    },
    {
        label: "Gender",
        field: (customer) => __(customer.gender),
        props: {
            class: "w-32",
        },
    },
    {
        label: "Status",
        field: (value) => __(value.status),
        component: {
            el: Badge,
            props: (item: Module) => {
                return {
                    severity: item.status === "active" ? "info" : "warning",
                };
            },
        },
        props: {
            class: "w-32",
        },
    },
    {
        label: "Created date",
        field: "created_at",
        props: {
            class: "w-40",
        },
    },
    {
        label: "Updated date",
        field: "updated_at",
        props: {
            class: "w-32",
        },
        hideFromIndex: true,
    },
];

export const filters = {
    ...globalFilter,
};

export default {
    columns,
    filters,
};
