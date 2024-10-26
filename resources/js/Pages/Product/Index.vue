<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { computed, ref } from "vue";
import categoryService from "@/services/category.service";
import { router } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import Form from "@/Pages/Category/Form.vue";
import { Products } from "@/types/models/product";

defineProps<{
    products: Products;
}>();

const columns: Column[] = categoryService.columns;

const selected = ref<Array<number>>([]);

const showForm = ref<boolean>(false);

const actions = computed(() => {
    const { add, refresh } = useAction();

    add.props.onClick = addForm;

    refresh.props.onClick = () => {
        router.reload({
            only: ["categories"],
        });
    };
    return [add, refresh];
});

function addForm() {
    showForm.value = true;
}
</script>

<template>
    <AppLayout title="Categories" :actions="actions">
        <template #header> Category Lists </template>

        <DataTable
            :values="products"
            :columns="columns"
            @page="(p) => router.reload({ data: { perPage: p } })"
            v-model:checked="selected"
            checkbox />

        <Form v-model:show="showForm" />
    </AppLayout>
</template>

<style scoped></style>
