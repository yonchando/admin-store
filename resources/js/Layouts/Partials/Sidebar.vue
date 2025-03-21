<script setup lang="ts">
import useMenu from "@/services/menu.service";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
import NavLink from "@/Components/Navs/NavLink.vue";
import { Menu } from "@/types";
import NavMenu from "@/Components/Menu/NavMenu.vue";
import { useSidebarStore } from "@/services/sidebar.service";
import { storeToRefs } from "pinia";

const page = usePage();

const sidebarStore = useSidebarStore();

const menus = computed(() => {
    if (sidebarStore.search_text) {
        return useMenu().filter((item: Menu) => {
            return item.title.toLowerCase().startsWith(sidebarStore.search_text.toLowerCase() ?? "");
        });
    }
    return useMenu();
});

const user = computed(() => page.props.auth.user);

const theme = ref(
    localStorage.getItem("theme") ?? (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"),
);

document.body.classList.add(theme.value);

function changeThemeMode() {
    if (theme.value === "dark") {
        document.body.classList.remove("dark");
        document.body.classList.add("light");
        theme.value = "light";
    } else {
        document.body.classList.remove("light");
        document.body.classList.add("dark");
        theme.value = "dark";
    }

    localStorage.setItem("theme", theme.value);
}
</script>

<template>
    <div
        class="relative flex min-w-16 max-w-72 flex-col overflow-auto overflow-y-auto scroll-auto border-r border-gray-300 bg-white py-4 lg:min-w-72 dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4 self-center overflow-hidden rounded-full">
            <img class="size-12 lg:size-48" src="@assets/images/logos/logo.png" alt="Logo" />
        </div>
        <!-- Profile -->
        <div class="hidden lg:mb-6 lg:block lg:px-2">
            <dropdown width="full" align="bottom">
                <template #trigger="{ active }">
                    <div
                        class="group flex cursor-pointer items-center rounded-md border-gray-300 bg-gray-200 p-2 hover:border-gray-300 hover:bg-gray-300 lg:border dark:border-gray-700 dark:bg-gray-900 dark:hover:bg-gray-700">
                        <img v-if="user.profile" src="" alt="" />
                        <div
                            v-else
                            class="flex size-10 items-center justify-center rounded-full bg-gray-300 group-hover:bg-gray-200 lg:mr-3 dark:bg-gray-700 group-hover:dark:bg-gray-800">
                            <span class="font-semibold text-gray-800 dark:text-gray-100">{{ user.name[0] }}</span>
                        </div>
                        <div class="hidden flex-col gap-2 lg:flex">
                            <span class="font-base font-medium">{{ user.name }}</span>
                            <span class="text-xs text-gray-600 dark:text-slate-400">{{ user.position }}</span>
                        </div>
                        <div class="ml-auto hidden lg:block">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                </template>

                <template #content>
                    <ul>
                        <li class="border-b dark:border-b-gray-800">
                            <nav-link :href="route('user.profile.edit')">Profile</nav-link>
                        </li>
                        <li>
                            <nav-link method="post" :href="route('logout')">Logout</nav-link>
                        </li>
                    </ul>
                </template>
            </dropdown>
        </div>

        <!-- Search -->
        <div class="relative hidden px-2 lg:block">
            <TextInput v-model="sidebarStore.search_text" placeholder="Search..." />
            <div
                v-if="sidebarStore.search_text"
                @click="sidebarStore.clearSearch()"
                class="absolute right-6 top-1/2 -translate-y-1/2 transform cursor-pointer">
                <i class="fa fa-times"></i>
            </div>
        </div>

        <!-- Menu -->
        <nav class="mt-4 w-full px-2">
            <NavMenu :menus="menus" />
        </nav>

        <!-- Footer -->
        <div class="mt-auto px-2 text-center lg:text-right">
            <button type="button" @click="changeThemeMode">
                <svg v-if="theme == 'light'" viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M17.715 15.15A6.5 6.5 0 0 1 9 6.035C6.106 6.922 4 9.645 4 12.867c0 3.94 3.153 7.136 7.042 7.136 3.101 0 5.734-2.032 6.673-4.853Z"
                        class="fill-gray-900"></path>
                    <path
                        d="m17.715 15.15.95.316a1 1 0 0 0-1.445-1.185l.495.869ZM9 6.035l.846.534a1 1 0 0 0-1.14-1.49L9 6.035Zm8.221 8.246a5.47 5.47 0 0 1-2.72.718v2a7.47 7.47 0 0 0 3.71-.98l-.99-1.738Zm-2.72.718A5.5 5.5 0 0 1 9 9.5H7a7.5 7.5 0 0 0 7.5 7.5v-2ZM9 9.5c0-1.079.31-2.082.845-2.93L8.153 5.5A7.47 7.47 0 0 0 7 9.5h2Zm-4 3.368C5 10.089 6.815 7.75 9.292 6.99L8.706 5.08C5.397 6.094 3 9.201 3 12.867h2Zm6.042 6.136C7.718 19.003 5 16.268 5 12.867H3c0 4.48 3.588 8.136 8.042 8.136v-2Zm5.725-4.17c-.81 2.433-3.074 4.17-5.725 4.17v2c3.552 0 6.553-2.327 7.622-5.537l-1.897-.632Z"
                        class="fill-gray-900"></path>
                </svg>
                <i v-else class="text-base">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="h-6 w-6 text-base">
                        <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" class="fill-white/20 stroke-white"></path>
                        <path
                            d="M12 4v1M17.66 6.344l-.828.828M20.005 12.004h-1M17.66 17.664l-.828-.828M12 20.01V19M6.34 17.664l.835-.836M3.995 12.004h1.01M6 6l.835.836"
                            class="stroke-white"></path>
                    </svg>
                </i>
            </button>
        </div>
    </div>
</template>

<style scoped></style>
