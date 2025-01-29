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

export function dataGet(item: any, key: string | ((t: any) => string)) {
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
    perPage: 20,
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
        current_page: null,
        first_page_url: null,
        from: null,
        last_page: null,
        last_page_url: null,
        links: null,
        next_page_url: null,
        path: null,
        per_page: null,
        prev_page_url: null,
        to: null,
        total: null,
        data: [],
    };
};
