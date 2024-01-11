<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard"/>

    <AppLayout>
        <Card>
            <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 dark:tw-text-gray-200 tw-leading-tight tw-mb-4">
                Dashboard</h2>


            <div class="tw-text-gray-900 dark:tw-text-gray-100">You're logged in!</div>
        </Card>
    </AppLayout>
</template>
