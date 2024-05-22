<script setup>
import { Transition } from "vue";
</script>

<template>
    <Transition name="slide-down">
        <slot />
    </Transition>
</template>

<style>
.slide-down-enter-active,
.slide-down-leave-active {
    transition: all 0.4s ease-in-out;
}

.slide-down-enter,
.slide-down-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>
