<script setup>
defineProps(['value']);
</script>

<template>
    <li class="nav-item-header">
        <div class="text-uppercase font-size-xs line-height-xs">
            <slot>
                {{ value }}
            </slot>
        </div>
    </li>
</template>

<style scoped>

</style>