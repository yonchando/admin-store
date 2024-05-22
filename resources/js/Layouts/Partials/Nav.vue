<script setup>
import NavLink from "@/Components/Navbar/NavLink.vue";

defineProps({
    menus: {
        type: [Array, Object],
        required: true,
    },
    subMenu: Boolean,
});
</script>

<template>
    <template v-for="menu in menus">
        <div class="mb-px">
            <NavLink
                :href="menu.link ?? '#'"
                :active="menu.active"
                :icon="menu.icon"
                :label="menu.label"
            />
        </div>

        <template v-if="menu.children?.length > 0">
            <Nav :menus="menu.children" sub-menu />
        </template>
    </template>
</template>
