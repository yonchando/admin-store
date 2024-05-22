<script setup>
import Navbar from "@/Layouts/Partials/Navbar.vue";
import MobileNav from "@/Layouts/Partials/MobileNav.vue";

defineEmits(["close-sidebar"]);

const props = defineProps({
    show: Boolean,
});
</script>

<template>
    <div
        :class="{
            'fixed inset-0 z-50 bg-dark-400/25': show,
        }"
    >
        <MobileNav :show="show" @close-sidebar="$emit('close-sidebar')" />
    </div>

    <Navbar class="hidden flex-col sm:inline-flex" />
</template>
