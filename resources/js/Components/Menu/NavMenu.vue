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
        active: "border border-gray-100 bg-white dark:border-gray-700 dark:bg-gray-900",
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
    <ul class="flex flex-col gap-1">
        <template v-for="menu in menus">
            <template v-if="!menu.disabled">
                <li v-if="!menu.children" class="text-center lg:text-left">
                    <Link
                        class="inline-flex w-full items-center rounded-md px-2 py-2.5 font-medium hover:bg-white hover:dark:bg-gray-900"
                        :class="[menu.isActive ? active : '']"
                        :href="menu.url">
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

                <li v-else class="w-full rounded-md text-center lg:text-left">
                    <a
                        href="#"
                        @click="openMenu(menu)"
                        :class="[menu.isActive ? active : '']"
                        class="mb-1 inline-flex w-full items-center rounded-md px-2 py-2.5 font-medium hover:bg-white hover:dark:bg-gray-900">
                        <div class="w-full lg:max-w-6">
                            <i v-if="typeof menu.icon === 'string'" :class="menu.icon" class="text-base lg:text-sm"></i>
                            <fa-icon v-else :icon="menu.icon" class="size-5 lg:size-4" />
                        </div>
                        <span class="hidden lg:block">
                            {{ menu.title }}
                        </span>
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
