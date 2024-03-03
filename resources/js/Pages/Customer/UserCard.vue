<script setup>

import Form from "@/Pages/Card/Form.vue";
import {ref} from "vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

defineProps(['customer']);

const isAdd = ref(false);
</script>

<template>
    <Form :user="customer" v-if="isAdd" @cancel="args => isAdd = false"/>

    <PrimaryButton @click="isAdd = true" v-else>
        Add
    </PrimaryButton>

</template>

<style scoped>

</style>
