<script setup lang="ts">
import { Categories, Category } from "@/types/models/category";
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import categoryService from "@/services/category.service";
import useAction from "@/services/action.service";
import Form from "@/Pages/Category/Form.vue";
import Alert from "@/Components/Alert/Alert.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps<{
    categories: Categories;
    sort: any;
}>();

const columns: Column[] = categoryService.columns;

const filters = reactive(categoryService.filters);

filters.page = props.categories.current_page;

filters.sortable = {
    field: props.sort?.field ?? "created_at",
    direction: props.sort?.direction ?? "asc",
};

const selected = ref<Array<number>>([]);

const showForm = ref<boolean>(false);

const show = ref(false);

const actions = computed(() => {
    const { add, edit, remove, refresh } = useAction();

    add.props.onClick = () => {
        showForm.value = true;
        category.value = null;
    };

    refresh.props.onClick = getData;

    edit.props.disabled = category.value == null;
    edit.props.onClick = () => (showForm.value = true);

    remove.props.disabled = category.value == null && selected.value.length === 0;
    remove.props.onClick = () => {
        show.value = true;
    };

    return [add, edit, remove, refresh];
});

const category = ref<Category | null>(null);

watch(filters, (value) => {
    getData();
});

function getData() {
    router.reload({
        data: filters,
    });
}

function destroy() {
    const ids = selected.value;

    if (category.value && !ids.includes(category.value?.id)) {
        ids.push(category.value?.id);
    }

    router.delete(route("category.destroy"), {
        data: {
            ids,
        },
        onSuccess: () => {
            show.value = false;
            category.value = null;
            selected.value = [];
        },
    });
}
</script>

<template>
    <AppLayout title="Category Lists" :actions="actions">
        <template #header> Category Lists</template>

        <DataTable
            :values="categories.data"
            :paginate="categories"
            :columns="columns"
            @search="
                (e) => {
                    filters.search = e;
                }
            "
            @page="(p) => router.reload({ data: { perPage: p, page: 1 } })"
            v-model:checked="selected"
            v-model:selected="category"
            v-model:sortable="filters.sortable"
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
