import { ColumnType } from "@/types/datatable/column";
import { Staff } from "@/types/models/staff";
import Badge from "@/Components/Badges/Badge.vue";
import { globalFilter } from "@/services/helper.service";
import Select from "@/Components/Forms/Select.vue";

export const columns: ColumnType<Staff>[] = [
    {
        label: "Name",
        field: "name",
        sortable: "name",
        props: {
            class: "w-40",
        },
    },
    {
        label: "Username",
        field: "username",
        sortable: "username",
        props: {
            class: "w-40",
        },
    },
    {
        label: "Gender",
        field: (s) => __(s.gender),
        props: {
            class: "w-32",
        },
        filters: {
            field: "gender",
            component: {
                el: Select,
                props: {
                    options: ["male", "female"],
                    optionLabel: (op: string) => __(op),
                },
            },
        },
    },
    {
        label: "Position",
        field: "position",
        props: {
            class: "w-32",
        },
    },
    {
        label: "Status",
        field: (s) => __(s.status),
        component: {
            el: Badge,
            props: (item: Staff) => {
                return {
                    severity: item.status == "active" ? "info" : "error",
                };
            },
        },
        props: {
            class: "w-32",
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
        props: {
            class: "w-32",
        },
    },
    {
        label: "Created date",
        field: "created_at",
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
