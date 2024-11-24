import { ColumnType } from "@/types/datatable/column";
import { globalFilter } from "@/services/helper.service";
import { Purchase } from "@/types/models/purchase";
import Badge from "@/Components/Badges/Badge.vue";

export const columns: ColumnType<Purchase>[] = [
    {
        label: "Ref no",
        field: "ref_no",
    },
    {
        label: "Customer",
        field: (item) => item.customer?.name,
    },
    {
        label: "Total",
        field: "total",
    },
    {
        label: "Items",
        field: "purchase_details_count",
        props: {
            class: "w-24",
        },
    },
    {
        label: "Status",
        field: (item) => __(item.status),
        component: {
            el: Badge,
            props: (item: Purchase) => {
                return {
                    severity: status[item.status],
                };
            },
        },
    },
    {
        label: "Purchase date",
        field: "created_at",
    },
];

export const filters = {
    ...globalFilter,
    total: null,
    status: null,
};

export const status = {
    pending: "warning",
    accepted: "primary",
    rejected: "error",
    completed: "success",
    cancel: "secondary",
};

export default {
    columns,
    filters,
};
