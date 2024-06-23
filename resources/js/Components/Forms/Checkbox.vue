<script setup>
import Checkbox from "primevue/checkbox";

const model = defineModel();
</script>

<template>
    <Checkbox v-model="model" />
</template>
