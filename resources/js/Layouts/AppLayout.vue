<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import HeaderTop from "@/Layouts/Partials/HeaderTop.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <HeaderTop />
</template>
