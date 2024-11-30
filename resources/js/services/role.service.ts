import { ColumnType } from "@/types/datatable/column";
import Badge from "@/Components/Badges/Badge.vue";
import { Product } from "@/types/models/product";
import { globalFilter } from "@/services/helper.service";
import { Role } from "@/types/models/role";
import Select from "@/Components/Forms/Select.vue";

export const columns: ColumnType<Role>[] = [
    {
        label: "Code",
        field: "code",
        sortable: "code",
        props: {
            class: "w-1/4",
        },
    },
    {
        label: "Name",
        field: "name",
        sortable: "name",
    },
    {
        label: "Status",
        field: (item) => __(item.status),
        props: {
            class: "w-48",
        },
        component: {
            el: Badge,
            props: (item: Product) => {
                return {
                    severity: item.status == "active" ? "info" : "error",
                };
            },
        },
        filters: {
            field: "status",
            component: {
                el: Select,
                props: {
                    options: ["active", "inactive"],
                    optionLabel: (op: string) => __(op),
                },
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
