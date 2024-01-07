<script setup>
import {usePage} from "@inertiajs/vue3";

const lang = usePage().props.lang;
</script>

<template>
    <div class="breadcrumb">
        <slot/>
    </div>
</template>

<style scoped>

</style>
