<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Menu } from "@/types";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { ref } from "vue";

const props = withDefaults(
    defineProps<{
        menus: Menu[];
        padding?: number;
        active?: string;
    }>(),
    {
        padding: 0,
        active: "active",
    },
);

const opens = ref<string[]>([]);

props.menus.forEach((menu) => {
    if (menu.isActive) {
        opens.value.push(menu.title);
    }
});

function openMenu(menu: Menu) {
    const index = opens.value.findIndex((item) => item == menu.title);

    if (index > -1) {
        opens.value.splice(index, 1);
    } else {
        opens.value.push(menu.title);
    }
}

function isOpen(menu: Menu) {
    return opens.value.filter((item: any) => menu.title == item).length > 0;
}
</script>

<template>
    <ul class="nav">
        <template v-for="menu in menus">
            <template v-if="!menu.disabled">
                <li v-if="!menu.children" class="nav-item">
                    <Link class="nav-link" :class="[menu.isActive ? active : '']" :href="menu.url">
                        <div class="flex w-full items-center" :style="{ 'padding-left': `${padding}rem` }">
                            <div class="w-full lg:max-w-6">
                                <i
                                    v-if="typeof menu.icon === 'string'"
                                    :class="menu.icon"
                                    class="text-base lg:text-sm"></i>
                                <fa-icon v-else :icon="menu.icon" class="size-5 lg:size-4" />
                            </div>
                            <div class="hidden lg:block">
                                {{ menu.title }}
                            </div>
                        </div>
                    </Link>
                </li>

                <li v-else class="nav-item">
                    <a href="#" @click="openMenu(menu)" :class="[menu.isActive ? active : '']" class="nav-link mb-1">
                        <span class="w-full lg:max-w-6">
                            <i v-if="typeof menu.icon === 'string'" :class="menu.icon" class="text-base lg:text-sm"></i>
                            <fa-icon v-else :icon="menu.icon" class="size-5 lg:size-4" />
                        </span>
                        {{ menu.title }}
                        <span class="ml-auto hidden lg:block">
                            <i v-if="!isOpen(menu)" class="fa fa-chevron-down"></i>
                            <i v-if="isOpen(menu)" class="fa fa-chevron-up"></i>
                        </span>
                    </a>

                    <Transition
                        enter-active-class="transition-[max-height] ease-in-out duration-300 overflow-hidden"
                        enter-from-class="max-h-0 "
                        enter-to-class="max-h-96 "
                        leave-active-class="transition-all ease-in-out duration-300 overflow-hidden"
                        leave-from-class="max-h-96"
                        leave-to-class="max-h-0">
                        <div v-show="isOpen(menu)">
                            <NavMenu :menus="menu.children" :padding="padding + 1.5" />
                        </div>
                    </Transition>
                </li>
            </template>
        </template>
    </ul>
</template>

<style scoped></style>
