import { Paginate } from "@/types/paginate";
import _ from "lodash";
import { defineStore } from "pinia";

export function callable(key: object | string | ((t: string) => string), values: any = {}) {
    if (typeof key === "function") {
        return key(values);
    } else {
        return key;
    }
}

export function dataGet(item: any, key: string | ((t: any) => any), index: number | undefined = undefined) {
    if (typeof key === "string") {
        return _.get(item, key);
    } else {
        return key(item);
    }
}

export function updateFilter(filters: any, values: any, callback: any = null) {
    for (const key in values) {
        filters[key] = values[key];
    }

    if (callback != null) {
        callback();
    }
}

export const globalFilter = {
    page: 1,
    perPage: 15,
    last_page: null,
    sortBy: {
        field: "created_at",
        direction: "desc",
    },
    search: "",
};

export const useAlertStore = defineStore("alerts", {
    state: () => {
        return {
            show: false,
            title: "Are you sure?",
            text: "Do you want to delete this?",
            type: "error" as "success" | "info" | "warning" | "error" | "question",
            confirmBtn: "error" as "primary" | "secondary" | "info" | "warning" | "error" | "success",
            confirmButtonText: "Yes",
            cancelBtn: "secondary" as "primary" | "secondary" | "info" | "warning" | "error" | "success",
            cancelButtonText: "Cancel",
        };
    },
    getters: {
        confirmType(state) {
            return {
                success: "success",
                info: "info",
                warning: "warning",
                error: "error",
                question: "primary",
            }[state.type] as "primary" | "secondary" | "info" | "warning" | "error" | "success";
        },
    },
    actions: {
        confirm() {},
        open() {
            this.show = true;
        },
        close() {
            this.show = false;
        },
    },
});

export const usePaginate = (): Paginate<any> => {
    return {
        data: [],
        meta: {
            current_page: 0,
            from: 0,
            last_page: 0,
            links: [],
            path: "",
            per_page: 25,
            to: 0,
            total: 0,
        },
        links: {
            first: null,
            last: null,
            next: null,
            prev: null,
        },
    };
};
