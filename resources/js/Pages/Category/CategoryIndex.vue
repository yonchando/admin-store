<script setup lang="ts">
import { Categories, Category } from "@/types/models/category";
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import categoryService from "@/services/category.service";
import useAction from "@/services/action.service";
import CategoryForm from "@/Pages/Category/CategoryForm.vue";
import Alert from "@/Components/Alert/Alert.vue";
import { router } from "@inertiajs/vue3";
import ButtonGroup from "@/Components/ButtonGroup.vue";

const props = defineProps<{
    categories: Categories;
    sort: any;
}>();

const columns: Column<Category>[] = categoryService.columns;

const filters = reactive(categoryService.filters);

filters.page = props.categories.current_page ?? 1;

const selectRows = ref<Array<number>>([]);

const showForm = ref<boolean>(false);

const confirmed = ref(false);

const actions = computed(() => {
    const { add, remove, refresh } = useAction();

    add.props.onClick = () => {
        showForm.value = true;
        category.value = null;
    };

    refresh.props.onClick = getData;

    remove.props.disabled = category.value == null && selectRows.value.length === 0;
    remove.props.onClick = () => {
        confirmed.value = true;
    };

    return [add, refresh, remove];
});

const category = ref<Category | null>(null);

watch(filters, () => {
    getData();
});

function search(e: string) {
    filters.search = e;
}

function getData() {
    router.reload({
        data: filters,
    });
}

function edit(item: Category) {
    showForm.value = true;
    category.value = item;
}

function destroy() {
    const ids = selectRows.value;

    if (category.value && !ids.includes(category.value?.id)) {
        ids.push(category.value?.id);
    }

    router.delete(route("category.destroy"), {
        data: {
            ids,
        },
        onSuccess: () => {
            confirmed.value = false;
            category.value = null;
            selectRows.value = [];
        },
    });
}

function changePage(p: number) {
    router.reload({ data: { perPage: p, page: 1 } });
}
</script>

<template>
    <AppLayout title="Category Lists" :actions="actions">
        <template #header> Category Lists</template>

        <DataTable
            :root="{
                actionClass: ['!w-20'],
            }"
            :values="categories.data"
            :paginate="categories"
            :columns="columns"
            @search="search"
            @showPage="changePage"
            @row-dbclick="edit"
            v-model:checked="selectRows"
            v-model:selectRow="category"
            v-model:sort-by="filters.sortBy"
            checkbox>
            <template #actions="{ item }">
                <ButtonGroup>
                    <Button size="xs" @click="edit(item)" severity="warning">Edit</Button>
                </ButtonGroup>
            </template>
        </DataTable>

        <CategoryForm v-if="showForm" v-model:show="showForm" :category="category" />

        <Alert
            @confirmed="destroy()"
            type="warning"
            title="Are you sure?"
            text="Do you want to delete this?"
            v-model:show="confirmed"
            confirm-button-type="error" />
    </AppLayout>
</template>

<style scoped></style>
