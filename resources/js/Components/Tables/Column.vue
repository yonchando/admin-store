<script setup lang="ts">
defineProps<{
    field?: string;
}>();
</script>

<template>
    <td class="column">
        <slot>{{ field }}</slot>
    </td>
</template>
