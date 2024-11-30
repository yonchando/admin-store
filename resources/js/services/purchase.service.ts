import { ColumnType } from "@/types/datatable/column";
import { globalFilter } from "@/services/helper.service";
import { Purchase, PurchaseDetail } from "@/types/models/purchase";
import Badge from "@/Components/Badges/Badge.vue";
import { currency } from "@/number_format";
import Button from "@/Components/Button.vue";

export const columns: ColumnType<Purchase>[] = [
    {
        label: "Ref no",
        field: "ref_no",
    },
    {
        label: "Customer",
        field: (item) => item.customer?.name,
        sortable: "customer",
        component: {
            el: Button,
            props: (c: Purchase) => {
                return {
                    href: route("customer.show", c.customer_id),
                };
            },
        },
    },
    {
        label: "Total",
        field: (item) => currency(item.total),
        sortable: "total",
    },
    {
        label: "Purchase count",
        field: "purchase_details_count",
    },
    {
        label: "Purchase date",
        field: "purchased_at",
        sortable: "purchased_at",
    },
    {
        label: "Status",
        field: (item) => __(item.status),
        component: {
            el: Badge,
            props: (item: Purchase) => {
                return {
                    severity: statusSeverity[item.status],
                };
            },
        },
    },
    {
        label: "Created date",
        field: "created_at",
        hideFromIndex: true,
    },
    {
        label: "Updated date",
        field: "updated_at",
        hideFromIndex: true,
    },
];

export const productColumns: ColumnType<PurchaseDetail>[] = [
    {
        label: "Product",
        field: "product_name",
    },
    {
        label: "Category",
        field: "category_name",
    },
    {
        label: "qty",
        field: "qty",
    },
    {
        label: "Unit price",
        field: (item) => currency(item.price),
    },
    {
        label: "Sub total",
        field: (item) => currency(item.sub_total),
    },
];

export const filters = {
    ...globalFilter,
    total: null,
    status: null,
};

export const status = {
    pending: "pending",
    accepted: "accepted",
    rejected: "rejected",
    completed: "completed",
    cancel: "cancel",
};

export const statusSeverity = {
    pending: "warning",
    accepted: "primary",
    rejected: "error",
    completed: "success",
    cancel: "secondary",
};

export default {
    columns,
    productColumns,
    filters,
    status,
};
