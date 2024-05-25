<script setup>
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";

defineProps({
    values: [Array],
});
</script>

<template>
    <div
        class="breadcrumbs mb-0 flex list-none flex-wrap space-x-2.5 rounded-none bg-transparent p-0"
    >
        <template v-for="value in values">
            <BreadcrumbItem
                class="breadcrumb-item"
                :label="value.label"
                :icon="value.icon"
            />
        </template>
    </div>
</template>

<style scoped>
.breadcrumbs .breadcrumb-item + .breadcrumb-item:before {
    content: "/";
    padding-right: 0.625rem;
    color: inherit;
    display: inline-block;
}
</style>
