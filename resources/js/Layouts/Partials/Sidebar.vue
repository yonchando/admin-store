<script setup>
import Navbar from "@/Layouts/Partials/Navbar.vue";
</script>

<template>
    <div class="sidebar sidebar-dark sidebar-main sidebar-fixed sidebar-expand-sm">
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>

        <div class="sidebar-content">
            <div class="card card-sidebar-mobile">
                <Navbar/>
            </div>
        </div>
    </div>
</template>

<style scoped></style>

