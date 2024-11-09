import _ from "lodash";

export function dataGet(item: any, key: string | ((t: any) => string)) {
    if (typeof key === "string") {
        return _.get(item, key);
    } else {
        return key(item);
    }
}

export const globalFilter = {
    page: 1,
    sortBy: {
        field: "created_at",
        direction: "desc",
    },
    search: "",
};
