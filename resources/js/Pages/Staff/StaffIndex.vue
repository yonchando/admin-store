<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import ButtonGroup from "@/Components/ButtonGroup.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Staff } from "@/types/models/staff";
import staffService from "@/services/staff.service";
import { Column } from "@/types/datatable/column";
import { Paginate } from "@/types/paginate";
import useAction from "@/services/action.service";
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";

defineProps<{
    staffs: Paginate<Staff>;
}>();

const selectRows = ref([]);
const columns: Column<Staff>[] = staffService.columns;

const actions = computed(() => {
    const { add, refresh, remove } = useAction();

    add.props.onClick = () => router.get(route("staff.create"));

    remove.props.disabled = selectRows.value.length === 0;

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
                <ButtonGroup>
                    <Button size="xs" :href="route('staff.show', item.id)" severity="info">View</Button>
                    <Button size="xs" :href="route('staff.edit', item.id)" severity="warning">Edit</Button>
                </ButtonGroup>
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
