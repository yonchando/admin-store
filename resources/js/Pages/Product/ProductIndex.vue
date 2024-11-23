<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import { Product, Products } from "@/types/models/product";
import productService from "@/services/product.service";
import Alert from "@/Components/Alert/Alert.vue";
import Action from "@/Components/Tables/Action.vue";

const props = defineProps<{
    products: Products;
    requests: any;
}>();

const columns: Column<Product>[] = productService.columns;

const selectRows = ref<Array<number>>([]);

const product = ref<Product | null>(null);

const filters = reactive(productService.filters);

filters.search = props.requests?.search;

watch(filters, () => {
    getData();
});

const confirmed = ref(false);

const actions = computed(() => {
    const { view, add, edit, remove, refresh } = useAction();

    view.props.onClick = () => router.get(route("product.show", product.value?.id));
    view.props.disabled = product.value == null;

    add.props.onClick = () => router.get(route("product.create"));

    edit.props.onClick = () => router.get(route("product.edit", product.value?.id));
    edit.props.disabled = product.value == null;

    remove.props.disabled = product.value == null && selectRows.value.length === 0;
    remove.props.onClick = () => {
        confirmed.value = true;
    };

    refresh.props.onClick = getData;
    return [add, refresh, remove];
});

function getData() {
    router.reload({
        data: filters,
    });
}

function destroy() {
    const ids = selectRows.value;

    if (product.value && !ids.includes(product.value?.id)) {
        ids.push(product.value?.id);
    }

    router.delete(route("product.destroy"), {
        data: {
            ids,
        },
        onSuccess: () => {
            confirmed.value = false;
            product.value = null;
            selectRows.value = [];
        },
    });
}

function search(e: string) {
    filters.search = e;
    filters.page = 1;
}

function pageChange(p: number) {
    router.reload({ data: { perPage: p } });
}

function show(item: Product) {
    router.get(route("product.show", item.id));
}
</script>

<template>
    <AppLayout title="Product Lists" :actions="actions">
        <template #header> Product Lists</template>

        <DataTable
            :values="products.data"
            :paginate="products"
            :columns="columns"
            :search="filters.search"
            @search="search"
            @showPage="pageChange"
            @row-dbclick="show"
            v-model:checked="selectRows"
            v-model:select-row="product"
            v-model:sortBy="filters.sortBy"
            checkbox>
            <template #actions="{ item }">
                <Action
                    :view="() => router.get(route('product.show', item.id))"
                    :edit="() => router.get(route('product.edit', item.id))" />
            </template>
        </DataTable>

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
