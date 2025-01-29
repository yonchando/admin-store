<script setup lang="ts">
import { Categories, Category } from "@/types/models/category";
import { ColumnType } from "@/types/datatable/column.d";
import { computed, ref } from "vue";
import categoryService from "@/services/category.service";
import useAction from "@/services/action.service";
import CategoryForm from "@/Pages/Category/CategoryForm.vue";
import { router } from "@inertiajs/vue3";
import TreeTable from "@/Components/TableTree/TreeTable.vue";
import { Paginate } from "@/types/paginate";
import axios from "axios";

const props = defineProps<{
    categories: Paginate<Category>;
    parents: Categories;
}>();

const columns: ColumnType<Category>[] = categoryService.columns;

const loading = ref(false);

const category = ref<Category | null>(null);

const showForm = ref<boolean>(false);

const actions = computed(() => {
    const { add, remove, refresh } = useAction();

    add.props.onClick = () => {
        showForm.value = true;
        category.value = null;
    };

    refresh.props.onClick = getData;

    return [add, refresh, remove];
});

const children = ref<any>({});

function getData() {
    loading.value = true;
    router.reload({
        onFinish() {
            loading.value = false;
        },
    });
}

function getChildren(item: Category) {
    if (item.open) {
        item.open = false;
        return;
    }

    if (item.children.length > 0) {
        item.open = true;
        return;
    }

    axios
        .get(route("category.index"), {
            params: {
                parent: item.id,
            },
        })
        .then((res) => {
            item.open = true;
            item.children = res.data.data;
        });
}
</script>

<template>
    <AppLayout title="Categories List" :actions="actions">
        <template #header>Categories List</template>

        <TreeTable
            :columns="columns"
            :values="categories.data"
            :meta="categories.meta"
            @expand-child="getChildren"
            v-model:children="children" />

        <CategoryForm v-if="showForm" v-model:show="showForm" :category="category" />
    </AppLayout>
</template>

<style scoped></style>
