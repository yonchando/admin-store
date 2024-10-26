<script setup lang="ts">
import { Categories, Category } from "@/types/models/category";
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { computed, ref } from "vue";
import categoryService from "@/services/category.service";
import { router } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import Form from "@/Pages/Category/Form.vue";
import Alert from "@/Components/Alert/Alert.vue";

defineProps<{
    categories: Categories;
}>();

const columns: Column[] = categoryService.columns;

const selected = ref<Array<number>>([]);

const showForm = ref<boolean>(false);

const show = ref(false);

const actions = computed(() => {
    const { add, edit, remove, refresh } = useAction();

    add.props.onClick = () => {
        showForm.value = true;
        category.value = null;
    };

    refresh.props.onClick = () => {
        router.reload({
            only: ["categories"],
        });
    };

    edit.props.disabled = category.value == null;
    edit.props.onClick = () => (showForm.value = true);

    remove.props.disabled = category.value == null;
    remove.props.onClick = () => {
        show.value = true;
    };

    return [add, edit, remove, refresh];
});

const category = ref<Category | null>(null);

function destroy() {
    router.delete(route("category.destroy", category.value?.id), {
        onSuccess: () => {
            show.value = false;
            category.value = null;
        },
    });
}
</script>

<template>
    <AppLayout title="Categories" :actions="actions">
        <template #header> Category Lists </template>

        <DataTable
            :values="categories"
            :columns="columns"
            @page="(p) => router.reload({ data: { perPage: p } })"
            v-model:checked="selected"
            v-model:selected="category"
            checkbox />

        <Form v-if="showForm" v-model:show="showForm" :category="category" />

        <Alert
            @confirmed="destroy()"
            type="warning"
            title="Are you sure?"
            text="Do you want to delete this?"
            v-model:show="show"
            confirm-button-type="error" />
    </AppLayout>
</template>

<style scoped></style>
