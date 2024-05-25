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
            active: isActive("dashboard"),
        },
        {
            label: lang.product_management,
            icon: faDolly,
            active: isActive(
                "product.index",
                "product.show",
                "product.create",
                "product.edit",
                "category.index",
                "product.option.group.index",
                "product.option.index",
            ),
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
            icon: "icon-store2",
            active: isActive("purchase.order.index"),
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
            icon: "icon-users2",
            children: [
                {
                    link: route("customer.index"),
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
            link: route("setting.show"),
            icon: "icon-gear",
            label: lang.setting,
            active: isActive("setting.show"),
        },
    ];
}
