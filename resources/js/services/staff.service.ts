import { ColumnType } from "@/types/datatable/column";
import { Staff } from "@/types/models/staff";
import Badge from "@/Components/Badges/Badge.vue";
import { globalFilter } from "@/services/helper.service";

export const columns: ColumnType<Staff>[] = [
    {
        label: "Name",
        field: "name",
        props: {
            class: "w-40",
        },
    },
    {
        label: "Username",
        field: "username",
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
    },
];

export const filters = {
    ...globalFilter,
};
export default {
    columns,
    filters,
};
