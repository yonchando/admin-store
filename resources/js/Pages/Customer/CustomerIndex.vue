<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ColumnType } from "@/types/datatable/column";
import { Paginate } from "@/types/paginate";
import useAction from "@/services/action.service";
import { computed, reactive, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { updateFilter, useAlertStore } from "@/services/helper.service";
import { Customer } from "@/types/models/customer";
import customerService from "@/services/customer.service";
import Action from "@/Components/Tables/Action.vue";
import { useFilters } from "@/services/datatable.service";

defineProps<{
    customers: Paginate<Customer>;
}>();

const selectRows = ref([]);
const columns: ColumnType<Customer>[] = customerService.columns;

const loading = ref(false);
const filters = useFilters(customerService.filters);

const actions = computed(() => {
    const { add, refresh, remove } = useAction();

    add.props.onClick = () => router.get(route("customer.create"));

    refresh.props.onClick = getData;

    remove.props.disabled = selectRows.value.length === 0;

    remove.props.onClick = () => {
        const alert = useAlertStore();
        alert.open();

        alert.confirm = () => {
            useForm({
                ids: selectRows.value,
            }).delete(route("customer.destroy"), {
                onFinish: () => {
                    alert.$reset();
                    selectRows.value = [];
                },
            });
        };
    };

    return [add, refresh, remove];
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
    <AppLayout :actions="actions" title="Customer Lists">
        <template #header> Customer Lists</template>
        <DataTable
            :values="customers.data"
            :paginate="customers"
            :columns="columns"
            :search="filters.search"
            @search="updateFilter(filters, { search: $event, page: 1 }, getData)"
            @filters="updateFilter(filters, $event, getData)"
            @rowDbclick="router.get(route('customer.show', $event.id))"
            v-model:checked="selectRows"
            v-model:loading="loading"
            checkbox>
            <template #actions="{ item }">
                <Action
                    :view="() => router.get(route('customer.show', item.id))"
                    :edit="() => router.get(route('customer.edit', item.id))" />
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
