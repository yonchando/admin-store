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
import { useAlertStore } from "@/services/helper.service";
import Action from "@/Components/Tables/Action.vue";

const props = defineProps<{
    categories: Categories;
    sort: any;
}>();

const columns: Column<Category>[] = categoryService.columns;

const filters = reactive(categoryService.filters);

filters.page = props.categories.current_page ?? 1;

const selectRows = ref<Array<number>>([]);

const showForm = ref<boolean>(false);

const actions = computed(() => {
    const { add, remove, refresh } = useAction();

    add.props.onClick = () => {
        showForm.value = true;
        category.value = null;
    };

    refresh.props.onClick = getData;

    remove.props.disabled = category.value == null && selectRows.value.length === 0;
    remove.props.onClick = () => {
        const alert = useAlertStore();
        alert.open();
        alert.confirm = () => {
            router.delete(route("category.destroy"), {
                data: {
                    ids: selectRows.value,
                },
                onSuccess() {
                    category.value = null;
                    selectRows.value = [];
                },
                onFinish() {
                    alert.close();
                },
            });
        };
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

function changePage(p: number) {
    router.reload({ data: { perPage: p, page: 1 } });
}
</script>

<template>
    <AppLayout title="Categories List" :actions="actions">
        <template #header>Categories List</template>

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
                <Action :edit="() => edit(item)" />
            </template>
        </DataTable>

        <CategoryForm v-if="showForm" v-model:show="showForm" :category="category" />
    </AppLayout>
</template>

<style scoped></style>
