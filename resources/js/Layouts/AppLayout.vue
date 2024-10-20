<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { ref } from "vue";

defineProps<{
    title?: string;
}>();

const theme = ref(
    localStorage.getItem("theme") ?? (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"),
);
</script>

<template>
    <Head :title="title">
        <link rel="icon" type="image/x-icon" href="@assets/images/logos/logo.png" />
    </Head>

    <div :class="[theme]">
        <div class="bg-gray-100 dark:bg-gray-900">
            <div class="flex">
                <Sidebar v-model="theme" />

                <div class="flex-grow">
                    <header class="bg-white px-2 py-3 shadow dark:bg-gray-800" v-if="$slots.header">
                        <h3 class="">
                            <slot name="header" />
                        </h3>
                    </header>

                    <!-- Page Content -->
                    <main class="max-h-[95.5vh] overflow-auto p-4">
                        <div class="rounded-md bg-white p-4 text-gray-900 dark:bg-gray-800 dark:text-gray-100">
                            <slot />
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
