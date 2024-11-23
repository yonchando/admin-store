import { usePage } from "@inertiajs/vue3";

export function __(key: string, attr: string = "") {
    const page = usePage();

    if (page.props.lang[key] == undefined) {
        return key;
    }

    return page.props.lang[key]?.replace(":attribute", attr);
}
window.__ = __;
