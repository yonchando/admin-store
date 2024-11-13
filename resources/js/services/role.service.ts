import { Column } from "@/types/datatable/column";
import Badge from "@/Components/Badges/Badge.vue";
import { Product } from "@/types/models/product";
import { globalFilter } from "@/services/helper.service";
import { Role } from "@/types/models/role";

export const columns: Column<Role>[] = [
    {
        label: "Code",
        field: "code",
        props: {
            class: "w-1/4",
        },
    },
    {
        label: "Name",
        field: "name",
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
