import {
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
            title: "Purchase Orders",
            url: route("product.index"),
            icon: faCircleDollarToSlot,
        }),
        add({
            title: "Customers",
            url: route("product.index"),
            icon: faUserTie,
        }),
        add({
            title: "Cards",
            url: route("card.index"),
            icon: faCreditCard,
        }),
        add({
            title: "User Management",
            url: "#",
            icon: faUsers,
            isActive: isActive(
                "staff.index",
                "staff.create",
                "staff.show",
                "staff.edit",
                "product.index",
                "module.index",
                "module.create",
                "module.show",
                "module.edit",
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
                    url: route("staff.index"),
                    icon: faIdCard,
                    isActive: isActive("product.index", "role.create", "role.show", "role.edit"),
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
