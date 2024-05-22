<script setup>
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
import Loading from "./Partials/Loading.vue";

defineProps({
    title: String,
});

const loading = ref(false);

router.on("start", () => {
    loading.value = true;
});

router.on("finish", () => {
    loading.value = false;
});
</script>

<template>
    <Head>
        <title>{{ title }}</title>
    </Head>

    <div
        class="mx-auto flex min-h-screen max-w-xs items-center"
    >
        <slot />
    </div>

    <Loading v-if="loading" />
</template>
