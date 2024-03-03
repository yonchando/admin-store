<script setup>
import {computed} from "vue";

const props = defineProps({
    value: String,
    type: {
        type: String,
        default: 'success',
    }
});

const badgeType = computed(() => {
    return {
        success: 'badge-success',
        info: 'badge-info',
        warning: 'badge-warning',
        danger: 'badge-danger',
        secondary: 'badge-secondary',
    }[props.type];
});

</script>

<template>
<span class="badge" :class="badgeType">
    <slot>
        {{ value }}
    </slot>
</span>
</template>

<style scoped>

</style>
