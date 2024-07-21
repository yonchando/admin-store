<script setup></script>

<template>
    <Transition enter-active-class="tw-transition-all tw-duration-400 tw-ease-in-out"
                leave-active-class="tw-transition-all tw-duration-400 tw-ease-in-out" 
                enter-from-class="tw-opacity-0"
                leave-to-class="tw-opacity-0"
    >
        <slot />
    </Transition>
</template>

<style scoped></style>
