<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { ColumnType } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import { Product } from "@/types/models/product";
import ButtonGroup from "@/Components/ButtonGroup.vue";
import purchaseService from "@/services/purchase.service";
import { Purchase } from "@/types/models/purchase";
import { Paginate } from "@/types/paginate";
import Action from "@/Components/Tables/Action.vue";

const props = defineProps<{
    purchases: Paginate<Purchase>;
    requests: any;
}>();

const columns: ColumnType<Purchase>[] = purchaseService.columns;

const selectRows = ref<Array<number>>([]);

const filters = reactive(purchaseService.filters);

filters.search = props.requests?.search;

watch(filters, () => {
    getData();
});

const actions = computed(() => {
    const { add, refresh } = useAction();

    add.props.onClick = () => router.get(route("purchase.create"));

    refresh.props.onClick = getData;
    return [add, refresh];
});

function getData() {
    router.reload({
        data: filters,
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
    <AppLayout title="Purchase Transactions List" :actions="actions">
        <template #header>Purchase Transactions List</template>

        <DataTable
            :values="purchases.data"
            :paginate="purchases"
            :columns="columns"
            :search="filters.search"
            @search="search"
            @showPage="pageChange"
            @row-dbclick="show"
            v-model:checked="selectRows"
            v-model:sortBy="filters.sortBy"
            checkbox>
            <template #actions="{ item }">
                <Action
                    :view="() => router.get(route('purchase.show', item.id))"
                    :edit="() => router.get(route('purchase.edit', item.id))" />
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
