<script setup>

import {usePage} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";

const lang = usePage().props.lang;

const menus = {
    dashboard: {
        link: route('dashboard'),
        text: lang.dashboard,
        icon: 'icon-home2'
    },
    category: {
        link: route('category.index'),
        text: lang.categories,
        icon: 'icon-grid4'
    },
    product: {
        link: route('product.index'),
        text: lang.products,
        icon: 'icon-box'
    },
    order: {
        link: route('purchase.order.index'),
        icon: 'icon-store2',
        text: lang.purchase_orders,
    },
    customer: {
        link: route('customer.index'),
        icon: 'icon-users',
        text: lang.customers
    },
    setting: {
        link: route('setting.show'),
        icon: 'icon-gear',
        text: lang.setting
    }
};
</script>

<template>
    <ul class="nav nav-sidebar" data-nav-type="accordion">
        <li class="nav-item-header">
            <div class="text-uppercase font-size-xs line-height-xs">
                {{ lang.dashboard }}
            </div>
        </li>

        <template v-for="menu in menus">
            <li class="nav-item">
                <NavLink class="nav-link" :href="menu.link ?? '#'" :active="menu.active">
                    <i v-if="menu.icon" :class="menu.icon"></i>
                    {{ menu.text }}
                </NavLink>
            </li>
        </template>

    </ul>
</template>

<style scoped>

</style>
