<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import Loading from "./Partials/Loading.vue";

const loading = ref(false);

router.on("start", () => {
    loading.value = true;
});

router.on("finish", () => {
    loading.value = false;
});
</script>

<template>
    <div class="page-content">
        <div class="content-wrapper">
            <div
                class="content d-flex justify-content-center align-items-center tw-h-screen"
            >
                <slot />
            </div>
        </div>
    </div>

    <Loading v-if="loading" />
</template>
