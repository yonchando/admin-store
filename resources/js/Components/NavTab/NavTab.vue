<script setup>
defineProps({
    navItems: Array,
})
</script>

<template>
    <ul class="tw-flex tw-gap-4">
        <template v-for="nav in navItems">
            <li>{{ nav.product_option_group.name }}</li>
        </template>
    </ul>

    <div class="">
        <slot/>
    </div>
</template>

<style scoped>

</style>