<script setup>

import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import {usePage} from "@inertiajs/vue3";

const title = usePage().props.lang.edit;
</script>

<template>
    <DropdownLink>
        <i class="icon-pencil7"></i>
        {{ title }}
    </DropdownLink>
</template>

<style scoped>

</style>