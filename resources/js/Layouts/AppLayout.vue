<script setup>
import Header from "@/Layouts/Partials/Header.vue";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumbs/Breadcrumb.vue";

defineProps({
    title: String,
    showSidebar: {
        type: Boolean,
        default: true,
    },
    showHeaderTop: {
        type: Boolean,
        default: true,
    },
});

const open = ref(false);
</script>

<template>
    <Head>
        <slot name="head">
            <title>{{ title }}</title>
        </slot>
    </Head>

    <div class="flex">
        <Sidebar
            v-if="showSidebar"
            :show="open"
            @close-sidebar="open = false"
        />

        <div class="flex-grow flex flex-col">
            <Header @open-sidebar="open = true">
                {{ title }}
            </Header>
            
            <Breadcrumb>
                <slot name="breadcrumb" />
            </Breadcrumb>
            
            <div class="h-10 w-full bg-gray-400"></div>
            
            <!-- body -->
            <div class="z-10 w-full grid-cols-1 overflow-auto">
                <div class="max-h-screen">
                    <div class="m-4">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
