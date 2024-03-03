<script setup>
defineProps({
    target: {
        type: String,
        require: true,
    },
    active: {
        type: Boolean
    }
})
</script>

<template>
    <li class="nav-item">
        <a :data-target="target" class="nav-link tw-cursor-pointer" :class="{active}" data-toggle="tab">
            <slot/>
        </a>
    </li>
</template>

<style scoped>

</style>
