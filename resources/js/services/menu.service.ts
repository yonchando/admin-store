import {
    faCartShopping,
    faCircleDollarToSlot,
    faCreditCard,
    faDolly,
    faGear,
    faHome,
    faIdCard,
    faLayerGroup,
    faUser,
    faUsers,
    faUserTie,
} from "@fortawesome/free-solid-svg-icons";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Menu } from "@/types";

function add(item: Menu): Menu {
    return {
        title: item.title,
        url: item.url ?? "#",
        icon: item.icon ?? null,
        children: item.children ?? undefined,
        isActive: item.isActive ?? false,
        disabled: item.disabled ?? false,
    };
}

const page = usePage();
const routeName = computed(() => page.props.routeName);

/**
 *
 * @param {route[]} items
 */
function isActive(...items: string[]) {
    return items.includes(routeName.value as string);
}

export default function useMenu() {
    return [
        add({
            title: "Dashboard",
            url: route("dashboard"),
            isActive: isActive("dashboard"),
            icon: faHome,
        }),
        add({
            title: "Categories",
            url: route("category.index"),
            icon: faLayerGroup,
            isActive: isActive("category.index", "category.create", "category.show", "category.edit"),
        }),
        add({
            title: "Products",
            url: route("product.index"),
            icon: faDolly,
            isActive: isActive("product.index", "product.create", "product.show", "product.edit"),
        }),
        add({
            title: "Purchase Transactions",
            url: route("purchase.index"),
            icon: faCartShopping,
            isActive: isActive("purchase.index", "purchase.create", "purchase.show", "purchase.edit"),
        }),
        add({
            title: "Customers",
            url: route("customer.index"),
            icon: faUserTie,
            isActive: isActive("customer.index", "customer.create", "customer.show", "customer.edit"),
        }),
        add({
            title: "Cards",
            url: route("card.index"),
            icon: faCreditCard,
            disabled: true,
        }),
        add({
            title: "Staff Management",
            url: "#",
            icon: faUsers,
            isActive: isActive(
                "staff.index",
                "staff.create",
                "staff.show",
                "staff.edit",
                "module.index",
                "module.create",
                "module.show",
                "module.edit",
                "role.index",
                "role.create",
                "role.show",
                "role.edit",
            ),
            children: [
                {
                    title: "Staffs",
                    url: route("staff.index"),
                    icon: faUser,
                    isActive: isActive("staff.index", "staff.create", "staff.show", "staff.edit"),
                },
                {
                    title: "Roles",
                    url: route("role.index"),
                    icon: faIdCard,
                    isActive: isActive("role.index", "role.create", "role.show", "role.edit"),
                },
                {
                    title: "Module",
                    url: route("module.index"),
                    icon: faLayerGroup,
                    isActive: isActive("module.index", "module.create", "module.show", "module.edit"),
                },
            ],
        }),
        add({
            title: "Setting",
            url: route("setting.show"),
            icon: faGear,
            isActive: isActive("setting.show"),
        }),
    ];
}
