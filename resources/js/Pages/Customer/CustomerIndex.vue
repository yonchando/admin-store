<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ColumnType } from "@/types/datatable/column";
import { Paginate } from "@/types/paginate";
import useAction from "@/services/action.service";
import { computed, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { useAlertStore } from "@/services/helper.service";
import { Customer } from "@/types/models/customer";
import customerService from "@/services/customer.service";
import Action from "@/Components/Tables/Action.vue";

defineProps<{
    customers: Paginate<Customer>;
}>();

const selectRows = ref([]);
const columns: ColumnType<Customer>[] = customerService.columns;

const actions = computed(() => {
    const { add, refresh, remove } = useAction();

    add.props.onClick = () => router.get(route("customer.create"));

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

function show(staff: Customer) {
    router.get(route("customer.show", staff.id));
}
</script>

<template>
    <AppLayout :actions="actions" title="Customer Lists">
        <template #header> Customer Lists</template>
        <DataTable
            :values="customers.data"
            v-model:checked="selectRows"
            :paginate="customers"
            @rowDbclick="show"
            :columns="columns">
            <template #actions="{ item }">
                <Action
                    :view="() => router.get(route('customer.show', item.id))"
                    :edit="() => router.get(route('customer.edit', item.id))" />
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
