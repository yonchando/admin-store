<script setup>
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import { computed } from "vue";
import useBreadcrumbs from "@/breadcrumbs.js";

const breadcrumbs = computed(() => {
    let breadcrumb = useBreadcrumbs();
    return (
        breadcrumb[route().current()] ?? [
            { label: "Dashboard", icon: "icon-home2" },
        ]
    );
});
</script>

<template>
    <!-- Breadcrumb -->
    <div
        class="relative flex flex-wrap border-y border-y-transparent bg-light-400 px-5"
    >
        <div
            class="breadcrumbs mb-0 flex list-none flex-wrap space-x-2.5 rounded-none bg-transparent p-0"
        >
            <template v-for="value in breadcrumbs">
                <BreadcrumbItem
                    class="breadcrumb-item"
                    :label="value.label"
                    :icon="value.icon"
                />
            </template>
            <slot />
        </div>
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
