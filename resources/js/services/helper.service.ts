import _ from "lodash";
import { defineStore } from "pinia";

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

export const useAlertStore = defineStore("alerts", {
    state: () => {
        return {
            show: false,
            title: "Are you sure?",
            text: "Do you want to delete this?",
            type: "error" as "success" | "info" | "warning" | "error" | "question",
            confirmBtn: "error" as "primary" | "secondary" | "info" | "warning" | "error" | "success",
            cancelBtn: "secondary" as "primary" | "secondary" | "info" | "warning" | "error" | "success",
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
