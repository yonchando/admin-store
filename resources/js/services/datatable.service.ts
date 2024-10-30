import { Column } from "@/types/datatable/column";
import _ from "lodash";

export function useDatatable(columns: Column[]) {
    return columns.filter((item) => {
        return !item.notOnTable;
    });
}
