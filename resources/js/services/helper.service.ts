import _ from "lodash";

export function dataGet(item, key: string | ((t: Type) => string)) {
    if (typeof key === "string") {
        return _.get(item, key);
    } else {
        return key(item);
    }
}
