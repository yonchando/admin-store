<script setup>

import {Head} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";

const {lang} = defineProps({
    lang: Object
})

</script>

<template>
    <Head :title="lang.product_show"/>

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem :href="route('product.index')" icon="icon-box" :title="lang.products"/>
        </template>
    </AppLayout>
</template>

<style scoped>

</style>