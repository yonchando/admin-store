<script setup>
import NavLink from "@/Components/Navbar/NavLink.vue";
import Collapse from "@/Components/Collapses/Collapse.vue";
import _ from "lodash";

defineProps({
    menus: {
        type: [Array, Object],
        required: true,
    },
    subMenu: Boolean,
    pt: {
        type: Object,
        default: {
            root: "",
            button: "",
        },
        validator(value) {
            return _.has(value, ["root", "button"]);
        },
    },
});
</script>

<template>
    <template v-for="menu in menus">
        <div
            v-if="!menu.children?.length"
            v-bind="$attrs"
            :class="{ 'bg-black/15': menu.active, 'pl-8': subMenu }"
            class="mb-px"
        >
            <NavLink :href="menu.link" :icon="menu.icon" :label="menu.label" />
        </div>

        <template v-else>
            <Collapse
                :pt="{
                    button: '',
                }"
                :show="menu.active"
            >
                <template #button="slotProps">
                    <div class="relative">
                        <nav-link
                            :active="menu.active"
                            :icon="menu.icon"
                            :label="menu.label"
                            class="w-full"
                            @click="slotProps.toggleClick"
                        />
                        <div
                            class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer"
                            @click="slotProps.toggleClick"
                        >
                            <i
                                v-if="!slotProps.isShow"
                                class="fa fa-chevron-down"
                            ></i>
                            <i
                                v-if="slotProps.isShow"
                                class="fa fa-chevron-up"
                            ></i>
                        </div>
                    </div>
                </template>

                <Nav :menus="menu.children" sub-menu />
            </Collapse>
        </template>
    </template>
</template>
