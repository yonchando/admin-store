import {
    faCircleDollarToSlot,
    faCreditCard,
    faDolly,
    faGear,
    faHome,
    faLayerGroup,
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
        children: item.children ?? [],
        isActive: item.isActive ?? false,
    };
}

const page = usePage();
const routeName = computed(() => page.props.routeName);

function isActive(...items: string[]) {
    return items.includes(routeName.value as string);
}

export default function useSidebar() {
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
            title: "Staffs",
            url: route("staff.index"),
            icon: faUsers,
        }),
        add({
            title: "Setting",
            url: route("setting.show"),
            icon: faGear,
        }),
    ];
}
