<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Staff } from "@/types/models/staff";
import { ColumnType } from "@/types/datatable/column";
import { Paginate } from "@/types/paginate";
import useAction from "@/services/action.service";
import { computed, onMounted, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import roleService from "@/services/role.service";
import { Role } from "@/types/models/role";
import { useAlertStore } from "@/services/helper.service";
import Action from "@/Components/Tables/Action.vue";

defineProps<{
    roles: Paginate<Staff>;
}>();

const selectRows = ref([]);
const columns: ColumnType<Role>[] = roleService.columns;

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

onMounted(() => {});
</script>

<template>
    <AppLayout :actions="actions" title="Role Lists">
        <template #header> Role Lists </template>
        <DataTable
            :values="roles.data"
            v-model:checked="selectRows"
            @rowDbclick="(role: Role) => router.get(route('role.show', role.id))"
            :paginate="roles"
            :columns="columns"
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
