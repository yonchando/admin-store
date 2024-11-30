<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { ColumnType } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import { Product, Products } from "@/types/models/product";
import productService from "@/services/product.service";
import Alert from "@/Components/Alert/Alert.vue";
import Action from "@/Components/Tables/Action.vue";
import { debounce, useAlertStore } from "@/services/helper.service";
import { Filters } from "@/types/datatable/datatable";

const props = defineProps<{
    products: Products;
    requests: any;
}>();

const columns: ColumnType<Product>[] = productService.columns;

const selectRows = ref<Array<number>>([]);

const loading = ref(false);

const filters: any = reactive({
    ...productService.filters,
    perPage: props.products.per_page,
    ...props.requests,
});

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

function getData() {
    filters.loading = true;
    router.reload({
        data: filters,
        onFinish() {
            filters.loading = false;
        },
    });
}

function search(s: string) {
    filters.search = s;
    selectRows.value = [];
    getData();
}

function show(item: Product) {
    router.get(route("product.show", item.id));
}

function changeFilters(filter: Filters) {
    for (const key in filter) {
        if (typeof filters[key] !== "undefined") {
            filters[key] = filter[key as keyof Filters];
        }
    }
    getData();
}
</script>

<template>
    <AppLayout title="Product Lists" :actions="actions">
        <template #header> Product Lists</template>

        <DataTable
            :values="products.data"
            :paginate="products"
            :columns="columns"
            @row-dbclick="show"
            :search="filters.search"
            @search="search"
            @filters="changeFilters"
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
