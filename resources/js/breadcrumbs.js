import { faDolly } from "@fortawesome/free-solid-svg-icons";

export default function useBreadcrumbs() {
    return {
        dashboard: [
            {
                label: "Dashboard",
                icon: "icon-home2",
            },
        ],
        "product.index": [
            {
                label: "Dashboard",
                icon: "icon-home2",
            },
            {
                label: "Products",
                icon: faDolly,
            },
        ],
        "product.create": [
            {
                label: "Dashboard",
                icon: "icon-home2",
            },
            {
                label: "Products",
                icon: faDolly,
            },
            {
                label: "Create Form",
                icon: "fa fa-plus",
            },
        ],
        "category.index": [
            {
                label: "Dashboard",
                icon: "icon-home2",
            },
            {
                label: "Categories",
                icon: "icon-grid4",
            },
        ],
    };
}
