<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { Action } from "@/types/button";

defineProps<{
    title?: string;
    actions?: Action[];
}>();
</script>

<template>
    <Head :title="title">
        <link rel="icon" type="image/x-icon" href="@assets/images/logos/logo.png" />
    </Head>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="flex">
            <Sidebar />

            <div class="relative flex-grow">
                <header class="sticky min-h-14 bg-white px-4 shadow dark:bg-gray-800" v-if="$slots.header">
                    <div class="flex w-full items-center">
                        <h3 class="">
                            <slot name="header" />
                        </h3>

                        <div class="ml-auto mt-4 inline-flex gap-2">
                            <template v-for="action in actions">
                                <div>
                                    <component :is="action.component" v-bind="action.props">
                                        <fa-icon :icon="action.icon" class="mr-2" />
                                        {{ action.label }}
                                    </component>
                                </div>
                            </template>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="mt-4 px-4">
                    <div class="rounded-md bg-white p-4 text-gray-900 dark:bg-gray-800 dark:text-gray-100">
                        <slot />
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>
