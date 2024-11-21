import { usePage } from "@inertiajs/vue3";

export function __(key: string, attr: string) {
    const page = usePage();

    return page.props.lang[key].replace(":attribute", attr);
}
window.__ = __;
