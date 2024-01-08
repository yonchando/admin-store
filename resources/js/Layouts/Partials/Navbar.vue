<script setup>

import {usePage} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";

const lang = usePage().props.lang;

const menus = {
    category: {
        link: route('category.index'),
        text: lang.categories
    },
    product: {
        link: route('category.index'),
        text: lang.products
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
                    {{ menu.text }}
                </NavLink>
            </li>
        </template>

    </ul>
</template>

<style scoped>

</style>
