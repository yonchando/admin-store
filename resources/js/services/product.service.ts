import { Column } from "@/types/datatable/column";

export const columns: Column[] = [
    {
        label: "Name",
        field: "product_name",
    },
    {
        label: "Price",
        field: "price",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Stock qty",
        field: "stock_qty",
        props: {
            class: "w-48",
        },
    },
];

export default {
    columns,
};
