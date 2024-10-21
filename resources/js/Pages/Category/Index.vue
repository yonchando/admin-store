<script setup lang="ts">
import { Categories, Category } from "@/types/models/category";
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { computed, ref } from "vue";
import categoryService from "@/Services/category.service";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import useAction from "@/Services/action.service";
import Form from "@/Pages/Category/Form.vue";

defineProps<{
    categories: Categories;
}>();

const columns: Column<Category>[] = categoryService.columns;

const selected = ref<Array<number>>([]);

const showForm = ref<boolean>(false);

const actions = computed(() => {
    const { view, add, refresh } = useAction();

    add.props.onClick = addForm;

    refresh.props.onClick = () => {
        router.reload({
            only: ["categories"],
        });
    };
    return [view, add, refresh];
});

function addForm() {
    showForm.value = true;
}
</script>

<template>
    <AppLayout title="Categories" :actions="actions">
        <template #header> Category Lists </template>

        <DataTable :values="categories" :columns="columns" v-model:checked="selected" checkbox />

        <Form v-model:show="showForm" />
    </AppLayout>
</template>

<style scoped></style>
