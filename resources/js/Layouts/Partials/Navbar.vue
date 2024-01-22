<script setup>
import {usePage} from "@inertiajs/vue3";
import NavLink from "@/Components/Navbar/NavLink.vue";
import NavHeader from "@/Components/Navbar/NavHeader.vue";

const $page = usePage();

const lang = $page.props.lang;

const menus = [
    {
        link: route('dashboard'),
        text: lang.dashboard,
        icon: 'icon-home2',
        active: $page.url === '/',
    }, {
        text: lang.product_management,
        children: [
            {
                link: route('category.index'),
                text: lang.categories,
                icon: 'icon-grid4',
                active: $page.url.startsWith('/category')
            },
            {
                link: route('product.index'),
                text: lang.products,
                icon: 'icon-bag',
                active: $page.url.startsWith('/product/') || $page.url === '/product'
            },
        ]
    },
    {
        text: lang.product_options,
        children: [
            {
                link: route('product.option.group.index'),
                text: lang.option_groups,
                icon: 'icon-price-tags',
                active: $page.url === '/product-option-group'
            },
            {
                link: route('product.option.index'),
                text: lang.options,
                icon: 'icon-price-tag',
                active: $page.url === '/product-option'
            },
        ]
    },
    {
        text: lang.purchase_management,
        children: [
            {
                link: route('purchase.order.index'),
                icon: 'icon-store2',
                text: lang.purchase_orders,
                active: $page.url.startsWith('/purchase-order')
            }
        ]
    },
    {
        text: lang.users,
        children: [{
            link: route('customer.index'),
            icon: 'icon-users2',
            text: lang.customers,
            active: $page.url === '/customer'
        }, {
            link: route('staff.index'),
            icon: 'icon-user-tie',
            text: lang.staffs,
            active: $page.url.startsWith('/staff')
        }]
    },
    {
        text: lang.setting,
        children: [
            {
                link: route('setting.show'),
                icon: 'icon-gear',
                text: lang.setting,
                active: $page.url === '/setting',
            }
        ],
    }
];
</script>

<template>
    <ul class="nav nav-sidebar" data-nav-type="accordion">
        <NavHeader>
            {{ lang.dashboard }}
        </NavHeader>

        <template v-for="menu in menus">
            <template v-if="menu.children?.length > 0">
                <NavHeader>
                    {{ menu.text }}
                </NavHeader>

                <template v-for="child in menu.children">
                    <li class="nav-item">
                        <NavLink class="nav-link" :href="child.link ?? '#'" :active="child.active">
                            <i v-if="child.icon" :class="child.icon"></i>
                            <span>{{ child.text }}</span>
                        </NavLink>
                    </li>
                </template>
            </template>
            <template v-else>
                <li class="nav-item">
                    <NavLink class="nav-link" :href="menu.link ?? '#'" :active="menu.active">
                        <i v-if="menu.icon" :class="menu.icon"></i>
                        <span>{{ menu.text }}</span>
                    </NavLink>
                </li>
            </template>
        </template>

    </ul>
</template>

<style scoped>

</style>
