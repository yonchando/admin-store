<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import Form from "@/Pages/Category/Form.vue";
import { Product, Products } from "@/types/models/product";
import productService from "@/services/product.service";

const props = defineProps<{
    products: Products;
    requests: any;
}>();

const columns: Column[] = productService.columns;

const selectRows = ref<Array<number>>([]);

const product = ref<Product | null>(null);

const filters = reactive(productService.filters);

filters.search = props.requests?.search;

watch(filters, () => {
    getData();
});

const actions = computed(() => {
    const { add, edit, refresh } = useAction();

    add.props.onClick = () => router.get(route("product.create"));

    edit.props.onClick = () => router.get(route("product.edit", product.value?.id));
    edit.props.disabled = product.value == null;

    refresh.props.onClick = getData;
    return [add, edit, refresh];
});

function getData() {
    router.reload({
        data: filters,
    });
}
</script>

<template>
    <AppLayout title="Product Lists" :actions="actions">
        <template #header> Product Lists </template>

        <DataTable
            :values="products.data"
            :paginate="products"
            :columns="columns"
            @search="
                (e) => {
                    filters.search = e;
                    filters.page = 1;
                }
            "
            :search="filters.search"
            @page="(p) => router.reload({ data: { perPage: p } })"
            v-model:checked="selectRows"
            v-model:selected="product"
            v-model:sortBy="filters.sortBy"
            checkbox />
    </AppLayout>
</template>

<style scoped></style>
