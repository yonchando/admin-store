import { usePage } from "@inertiajs/vue3";
import { faDolly } from "@fortawesome/free-solid-svg-icons";

export default function useMenu() {
    const $page = usePage();

    const lang = $page.props.lang;

    function isActive(...urls) {
        return urls.some((url) => route().current(url));
    }

    return [
        {
            link: route("dashboard"),
            label: lang.dashboard,
            icon: "icon-home2",
            active: $page.url === "/",
        },
        {
            label: lang.product_management,
            icon: faDolly,
            children: [
                {
                    link: route("product.index"),
                    label: lang.products,
                    icon: "icon-bag",
                    active: isActive(
                        "product.index",
                        "product.show",
                        "product.create",
                        "product.edit",
                    ),
                },
                {
                    link: route("category.index"),
                    label: lang.categories,
                    icon: "icon-grid4",
                    active: isActive("category.index"),
                },
                {
                    link: route("product.option.group.index"),
                    label: lang.option_groups,
                    icon: "icon-price-tags",
                    active: isActive("product.option.group.index"),
                },
                {
                    link: route("product.option.index"),
                    label: lang.options,
                    icon: "icon-price-tag",
                    active: isActive("product.option.index"),
                },
            ],
        },
        {
            label: lang.purchase_management,
            children: [
                {
                    link: route("purchase.order.index"),
                    icon: "icon-store2",
                    label: lang.purchase_orders,
                    active: isActive("purchase.order.index"),
                },
            ],
        },
        {
            label: lang.users,
            children: [
                {
                    link: route("customer.index"),
                    icon: "icon-users2",
                    label: lang.customers,
                    active: isActive("customer.index"),
                },
                {
                    link: route("staff.index"),
                    icon: "icon-user-tie",
                    label: lang.staffs,
                    active: isActive("staff.index"),
                },
            ],
        },
        {
            label: lang.setting,
            children: [
                {
                    link: route("setting.show"),
                    icon: "icon-gear",
                    label: lang.setting,
                    active: isActive("setting.show"),
                },
            ],
        },
    ];
}
