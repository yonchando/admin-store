<script setup>
defineProps({
    navItems: Array,
})
</script>

<template>
    <ul class="nav nav-tabs nav-tabs-bottom">
        <slot name="tabs"/>
    </ul>

    <div class="tab-content">
        <slot/>
    </div>
</template>

<style scoped>

</style>
