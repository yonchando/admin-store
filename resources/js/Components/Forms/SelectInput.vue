<script setup>
import Dropdown from "primevue/dropdown";

defineOptions({
    inheritAttrs: false,
});

</script>

<template>
    <div class="select">
        <Dropdown v-bind="$attrs" />
    </div>
</template>

<style scoped></style>
