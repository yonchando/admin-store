import { defineStore } from "pinia";

export const useSidebarStore = defineStore("sidebar", {
    state() {
        return {
            search_text: "" as string,
        };
    },
    actions: {
        search(s: string) {
            this.search_text = s;
        },
        clearSearch() {
            this.$reset();
        },
    },
});
