<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { ColumnType } from "@/types/datatable/column.d";
import { computed, reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import { Product, Products } from "@/types/models/product";
import productService from "@/services/product.service";
import Action from "@/Components/Tables/Action.vue";
import { updateFilter, useAlertStore } from "@/services/helper.service";
import { useFilters } from "@/services/datatable.service";
import purchaseService from "@/services/purchase.service";
import { Paginate } from "@/types/paginate";
import { Category } from "@/types/models/category";

const props = defineProps<{
    products: Products;
    statuses: object;
    categories: Paginate<Category>;
    requests: any;
}>();

const columns: ColumnType<Product>[] = productService.columns;

const selectRows = ref<Array<number>>([]);

const loading = ref(false);

const filters: any = useFilters(purchaseService.filters);

const actions = computed(() => {
    const { add, remove, refresh } = useAction();

    add.props.onClick = () => router.get(route("product.create"));

    remove.props.disabled = selectRows.value.length === 0;
    remove.props.onClick = () => {
        const alert = useAlertStore();
        alert.show = true;

        alert.confirm = () => {
            const ids = selectRows.value;

            router.delete(route("product.destroy"), {
                data: {
                    ids,
                },
                onSuccess: () => {
                    selectRows.value = [];
                    alert.show = false;
                },
            });
        };
    };

    refresh.props.onClick = getData;
    return [add, refresh, remove];
});

const filtersData = reactive({
    categories: props.categories,
    statuses: props.statuses,
});

function getData() {
    loading.value = true;
    router.reload({
        data: filters,
        onFinish() {
            loading.value = false;
        },
    });
}
</script>

<template>
    <AppLayout title="Product Lists" :actions="actions">
        <template #header> Product Lists</template>

        <DataTable
            :values="products.data"
            :meta="products.meta"
            :columns="columns"
            :search="filters.search"
            :filters-data="filtersData"
            :filters="filters"
            @search="updateFilter(filters, { search: $event, page: 1 }, getData)"
            @filters="updateFilter(filters, $event, getData)"
            @row-dbclick="router.get(route('product.show', $event.id))"
            v-model:loading="loading"
            v-model:checked="selectRows">
            <template #actions="{ item }">
                <Action
                    :view="() => router.get(route('product.show', item.id))"
                    :edit="() => router.get(route('product.edit', item.id))" />
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
