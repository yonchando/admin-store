<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { ref } from "vue";

defineProps<{
    title?: string;
}>();

const theme = ref(localStorage.getItem("theme"));
</script>

<template>
    <Head :title="title">
        <link rel="icon" type="image/x-icon" href="@assets/images/logos/logo.png" />
    </Head>

    <div :class="{ dark: theme === 'dark' }">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="grid grid-cols-12">
                <Sidebar v-model="theme" class="col-span-2" />

                <div class="col-span-9">
                    <!-- Page Heading -->
                    <header class="bg-white shadow dark:bg-gray-800" v-if="$slots.header">
                        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                            <slot name="header" />
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main>
                        <slot />
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
