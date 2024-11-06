import { Column } from "@/types/datatable/column";
import { Staff } from "@/types/models/staff";
import Badge from "@/Components/Badges/Badge.vue";

export const columns: Column<Staff>[] = [
    {
        label: "Name",
        field: "name",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Username",
        field: "username",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Gender",
        field: "gender",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Position",
        field: "position",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Status",
        field: "status",
        component: {
            el: Badge,
            props: (item: Staff) => {
                return {
                    severity: item.status == "active" ? "info" : "error",
                };
            },
        },
        props: {
            class: "w-48",
        },
    },
];
export default {
    columns,
};
