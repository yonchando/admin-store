<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { ColumnType } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import useAction from "@/services/action.service";
import { router, useForm } from "@inertiajs/vue3";
import moduleService from "@/services/module.service";
import { Module } from "@/types/models/module";
import ModuleForm from "@/Pages/Module/ModuleForm.vue";
import { useAlertStore } from "@/services/helper.service";
import Action from "@/Components/Tables/Action.vue";

const alert = useAlertStore();
alert.confirm = () => {
    const ids = selectRows.value;

    if (module.value && !ids.includes(module.value?.id)) {
        ids.push(module.value?.id);
    }

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

defineProps<{
    data: Module[];
    sort: any;
    statuses: Array<string>;
    permissions: any;
}>();

const columns: ColumnType<Module>[] = moduleService.columns;

const filters = reactive(moduleService.filters);

const selectRows = ref<Array<number>>([]);

const showForm = ref<boolean>(false);

const confirmed = ref(false);

const actions = computed(() => {
    const { add, remove, refresh } = useAction();

    add.props.onClick = () => {
        showForm.value = true;
        module.value = null;
    };

    refresh.props.onClick = getData;

    remove.props.disabled = selectRows.value.length === 0;
    remove.props.onClick = () => {
        alert.open();
    };

    return [add, refresh, remove];
});

const module = ref<Module | null>(null);

watch(filters, () => {
    getData();
});

function search(e: string) {
    filters.search = e;
}

function getData() {
    router.reload({
        data: filters,
    });
}

function edit(item: Module) {
    showForm.value = true;
    module.value = item;
}

function destroy(item: Module) {
    alert.open();
    module.value = item;
}
</script>

<template>
    <AppLayout title="Category Lists" :actions="actions">
        <template #header> Module Lists</template>

        <DataTable
            :root="{
                actionClass: ['!w-6'],
                checkBoxClass: ['!w-3'],
            }"
            :values="data"
            :columns="columns"
            @search="search"
            @row-dbclick="edit"
            v-model:checked="selectRows"
            v-model:selectRow="module"
            v-model:sort-by="filters.sortBy"
            checkbox>
            <template #actions="{ item }">
                <Action :edit="() => edit(item)" :destroy="() => destroy(item)" />
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
