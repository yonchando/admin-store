<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { ColumnType } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import useAction from "@/services/action.service";
import { router, useForm } from "@inertiajs/vue3";
import moduleService from "@/services/module.service";
import { Module } from "@/types/models/module";
import ModuleForm from "@/Pages/Module/ModuleForm.vue";
import { updateFilter, useAlertStore } from "@/services/helper.service";
import Action from "@/Components/Tables/Action.vue";
import { Filters } from "@/types/datatable/datatable";
import { useFilters } from "@/services/datatable.service";

const props = defineProps<{
    data: Module[];
    sort: any;
    statuses: Array<string>;
    permissions: any;
    requests: any;
}>();

const columns: ColumnType<Module>[] = moduleService.columns;

const filters = useFilters(moduleService.filters);

const loading = ref(false);

const selectRows = ref<Array<number>>([]);

const showForm = ref<boolean>(false);

const actions = computed(() => {
    const { add, remove, refresh } = useAction();

    add.props.onClick = () => {
        showForm.value = true;
        module.value = null;
    };

    refresh.props.onClick = getData;

    remove.props.disabled = selectRows.value.length === 0;
    remove.props.onClick = () => {
        const alert = useAlertStore();
        alert.open();
        alert.confirm = () => {
            const ids = selectRows.value;
            useForm({
                ids,
            }).delete(route("module.destroy"), {
                onFinish: () => {
                    alert.$reset();
                    module.value = null;
                    selectRows.value = [];
                },
            });
        };
    };

    return [add, refresh, remove];
});

const module = ref<Module | null>(null);

function getData() {
    loading.value = true;
    router.reload({
        data: filters,
        onFinish: () => {
            loading.value = false;
        },
    });
}

function edit(item: Module) {
    showForm.value = true;
    module.value = item;
}
</script>

<template>
    <AppLayout title="Category Lists" :actions="actions">
        <template #header> Module Lists</template>

        <DataTable
            :root="{
                actionClass: ['w-6'],
                checkBoxClass: ['w-3'],
            }"
            :values="data"
            :columns="columns"
            :filters="filters"
            :search="filters.search"
            @search="updateFilter(filters, { search: $event, page: 1 }, getData)"
            @filters="updateFilter(filters, $event, getData)"
            @row-dbclick="edit"
            v-model:checked="selectRows"
            checkbox>
            <template #actions="{ item }">
                <Action :edit="() => edit(item)" />
            </template>
        </DataTable>

        <ModuleForm
            v-if="showForm"
            v-model:show="showForm"
            :permissions="permissions"
            :statuses="statuses"
            :module="module" />
    </AppLayout>
</template>

<style scoped></style>
