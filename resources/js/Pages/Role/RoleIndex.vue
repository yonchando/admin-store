<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import ButtonGroup from "@/Components/ButtonGroup.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Staff } from "@/types/models/staff";
import { Column } from "@/types/datatable/column";
import { Paginate } from "@/types/paginate";
import useAction from "@/services/action.service";
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import roleService from "@/services/role.service";
import { Role } from "@/types/models/role";

const props = defineProps<{
    roles: Paginate<Staff>;
}>();

const selectRows = ref();
const columns: Column<Role>[] = roleService.columns;

const { add, refresh, remove } = useAction();

add.props.onClick = () => router.get(route("role.create"));

const actions = [add, refresh, remove];

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
                <ButtonGroup>
                    <Button size="xs" :href="route('role.show', item.id)" severity="info">
                        <i class="fa fa-eye"></i>
                    </Button>
                    <Button size="xs" :href="route('role.edit', item.id)" severity="warning">
                        <i class="fa fa-pen"></i>
                    </Button>
                </ButtonGroup>
            </template>
        </DataTable>
    </AppLayout>
</template>

<style scoped></style>
