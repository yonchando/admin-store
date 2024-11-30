<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Staff } from "@/types/models/staff";
import staffService from "@/services/staff.service";
import { ColumnType } from "@/types/datatable/column";
import { Paginate } from "@/types/paginate";
import useAction from "@/services/action.service";
import { computed, reactive, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { updateFilter, useAlertStore } from "@/services/helper.service";
import Action from "@/Components/Tables/Action.vue";
import { useFilters } from "@/services/datatable.service";

defineProps<{
    staffs: Paginate<Staff>;
}>();

const selectRows = ref([]);
const columns: ColumnType<Staff>[] = staffService.columns;

const loading = ref(false);
const filters = useFilters({
    ...staffService.filters,
});

const actions = computed(() => {
    const { add, refresh, remove } = useAction();

    add.props.onClick = () => router.get(route("staff.create"));

    refresh.props.onClick = getData;

    remove.props.disabled = selectRows.value.length === 0;

    remove.props.onClick = () => {
        const alert = useAlertStore();
        alert.open();

        alert.confirm = () => {
            useForm({
                ids: selectRows.value,
            }).delete(route("staff.destroy"), {
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
    <AppLayout :actions="actions" title="Staff Lists">
        <template #header> Staff Lists </template>
        <DataTable
            :root="{
                actionClass: 'w-16',
                checkBoxClass: 'w-6',
            }"
            :values="staffs.data"
            :paginate="staffs"
            :columns="columns"
            :search="filters.search"
            @search="updateFilter(filters, { search: $event, page: 1 }, getData)"
            @filters="updateFilter(filters, $event, getData)"
            @rowDbclick="router.get(route('staff.show', $event.id))"
            v-model:loading="loading"
            v-model:checked="selectRows"
            checkbox>
            <template #actions="{ item }">
                <Action
                    :view="() => router.get(route('staff.show', item.id))"
                    :edit="() => router.get(route('staff.edit', item.id))" />
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
