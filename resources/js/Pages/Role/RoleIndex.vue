<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Staff } from "@/types/models/staff";
import { ColumnType } from "@/types/datatable/column";
import { Paginate } from "@/types/paginate";
import useAction from "@/services/action.service";
import { computed, onMounted, reactive, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import roleService from "@/services/role.service";
import { Role } from "@/types/models/role";
import { updateFilter, useAlertStore } from "@/services/helper.service";
import Action from "@/Components/Tables/Action.vue";
import { useFilters } from "@/services/datatable.service";

defineProps<{
    roles: Paginate<Staff>;
}>();

const selectRows = ref([]);
const columns: ColumnType<Role>[] = roleService.columns;

const loading = ref(false);

const filters = useFilters(roleService.filters);

const actions = computed(() => {
    const { add, refresh, remove } = useAction();

    add.props.onClick = () => router.get(route("role.create"));

    remove.props.disabled = selectRows.value.length === 0;
    remove.props.onClick = () => {
        const alert = useAlertStore();
        alert.open();

        alert.confirm = () => {
            useForm({
                ids: selectRows.value,
            }).delete(route("role.destroy"), {
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

function show(role: Role) {}
</script>

<template>
    <AppLayout :actions="actions" title="Role Lists">
        <template #header> Role Lists </template>
        <DataTable
            :values="roles.data"
            :paginate="roles"
            :columns="columns"
            :search="filters.search"
            @search="updateFilter(filters, { search: $event, page: 1 }, getData)"
            @filters="updateFilter(filters, $event, getData)"
            @rowDbclick="router.get(route('role.show', $event.id))"
            v-model:checked="selectRows"
            v-model:loading="loading"
            checkbox>
            <template #actions="{ item }">
                <Action
                    :view="() => router.get(route('role.show', item.id))"
                    :edit="() => router.get(route('role.edit', item.id))" />
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
