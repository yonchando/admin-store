<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Staff } from "@/types/models/staff";
import staffService from "@/services/staff.service";
import { ColumnType } from "@/types/datatable/column";
import { Paginate } from "@/types/paginate";
import useAction from "@/services/action.service";
import { computed, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { useAlertStore } from "@/services/helper.service";
import Action from "@/Components/Tables/Action.vue";

defineProps<{
    staffs: Paginate<Staff>;
}>();

const selectRows = ref([]);
const columns: ColumnType<Staff>[] = staffService.columns;

const actions = computed(() => {
    const { add, refresh, remove } = useAction();

    add.props.onClick = () => router.get(route("staff.create"));

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

function show(staff: Staff) {
    router.get(route("staff.show", staff.id));
}
</script>

<template>
    <AppLayout :actions="actions" title="Staff Lists">
        <template #header> Staff Lists </template>
        <DataTable
            :values="staffs.data"
            v-model:checked="selectRows"
            :paginate="staffs"
            @rowDbclick="show"
            :columns="columns"
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
