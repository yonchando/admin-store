<script setup>
import HeaderTop from "@/Layouts/Partials/HeaderTop.vue";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";

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

    <div class="block sm:flex">
        <div>
            <HeaderTop @open-sidebar="open = true" />
            <Sidebar
                v-if="showSidebar"
                :show="open"
                @close-sidebar="open = false"
            />
        </div>

        <div class="z-10 w-full grid-cols-1 overflow-auto">
            <div class="max-h-screen sm:pt-14">
                <div class="m-4">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
