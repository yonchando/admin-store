<script setup>
defineProps({
    width: {
        type: Number,
        default: 240,
    },
    height: {
        type: Number,
        default: 240,
    },
});
</script>
<template>
    <div
        class="overflow-hidden rounded-full"
        :style="{
            width: width + 'px',
            height: height + 'px',
        }"
    >
        <img
            class="h-auto w-full"
            src="/assets/images/logos/logo.png"
            alt="Logo"
        />
    </div>
</template>
