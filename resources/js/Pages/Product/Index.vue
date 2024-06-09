<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import useActions from "@/actions.js";

const props = defineProps([
    "lang",
    "products",
    "categories",
    "statuses",
    "filters",
    "errors",
]);

const actions = useActions({
    create: () => {
        console.log("create");
    },
    refresh: () => {
        console.log("refresh")
    }
});
</script>

<template>
    <AppLayout :title="lang.products" :actions="actions">
    </AppLayout>
</template>

<style scoped></style>
