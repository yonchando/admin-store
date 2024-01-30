<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <Card>
            <h2
                class="tw-mb-4 tw-text-xl tw-font-semibold tw-leading-tight tw-text-gray-800 dark:tw-text-gray-200"
            >
                Dashboard
            </h2>

            <div class="tw-text-gray-900 dark:tw-text-gray-100">
                You're logged in!
            </div>
        </Card>
    </AppLayout>
</template>
