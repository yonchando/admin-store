import { usePage } from "@inertiajs/vue3";
import { reactive } from "vue";

export function useFilters(filters: any = {}): any {
    const page = usePage();

    const requests = page.props?.requests ?? {};

    return reactive({
        ...filters,
        ...requests,
    });
}
