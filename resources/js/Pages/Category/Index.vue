<script setup lang="ts">
import { Categories, Category } from "@/types/models/category";
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { ref } from "vue";
import categoryService from "@/Services/category.service";

defineProps<{
    categories: Categories;
}>();

const columns: Column<Category>[] = categoryService.columns;

const selected = ref<Array<number>>([]);
</script>

<template>
    <AppLayout title="Categories">
        <template #header=""> Category Lists</template>

        <DataTable :values="categories" :columns="columns" v-model:checked="selected" checkbox />
    </AppLayout>
</template>

<style scoped></style>
