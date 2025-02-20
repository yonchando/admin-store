<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { ColumnType } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import purchaseService from "@/services/purchase.service";
import { Purchase } from "@/types/models/purchase";
import { Paginate } from "@/types/paginate";
import Action from "@/Components/Tables/Action.vue";
import { useFilters } from "@/services/datatable.service";
import { updateFilter } from "@/services/helper.service";

defineProps<{
    purchases: Paginate<Purchase>;
}>();

const columns: ColumnType<Purchase>[] = purchaseService.columns;

const selectRows = ref<Array<number>>([]);

const loading = ref(false);
const filters = useFilters(purchaseService.filters);

const actions = computed(() => {
    const { add, refresh } = useAction();

    add.props.onClick = () => router.get(route("purchase.create"));

    refresh.props.onClick = getData;
    return [add, refresh];
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
    <AppLayout title="Purchase Transactions List" :actions="actions">
        <template #header>Purchase Transactions List</template>

        <DataTable :values="purchases.data" :paginate="purchases" :columns="columns" :search="filters.search"
            @search="updateFilter(filters, { search: $event, page: 1 }, getData)"
            @filters="updateFilter(filters, $event, getData)"
            @row-dbclick="router.get(route('purchase.show', $event.id))" v-model:checked="selectRows"
            v-model:loading="loading">
            <template #actions="{ item }">
                <Action :view="() => router.get(route('purchase.show', item.id))"
                    :edit="() => router.get(route('purchase.edit', item.id))" />
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
