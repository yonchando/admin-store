<script setup lang="ts">
import DataTable from "@/Components/Tables/DataTable.vue";
import { Column } from "@/types/datatable/column.d";
import { computed, reactive, ref, watch } from "vue";
import useAction from "@/services/action.service";
import Alert from "@/Components/Alert/Alert.vue";
import { router } from "@inertiajs/vue3";
import ButtonGroup from "@/Components/ButtonGroup.vue";
import moduleService from "@/services/module.service";
import { Module } from "@/types/models/module";
import ModuleForm from "@/Pages/Module/ModuleForm.vue";

const props = defineProps<{
    data: Module[];
    sort: any;
    statuses: Array<string>;
    permissions: any;
}>();

const columns: Column<Module>[] = moduleService.columns;

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

    remove.props.disabled = module.value == null && selectRows.value.length === 0;
    remove.props.onClick = () => {
        confirmed.value = true;
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

function remove(item: Module) {
    confirmed.value = true;
    module.value = item;
}

function destroy() {
    const ids = selectRows.value;

    if (module.value && !ids.includes(module.value?.id)) {
        ids.push(module.value?.id);
    }

    router.delete(route("module.destroy"), {
        data: {
            ids,
        },
        onSuccess: () => {
            confirmed.value = false;
            module.value = null;
            selectRows.value = [];
        },
    });
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
                <ButtonGroup>
                    <Button size="xs" @click="edit(item)" severity="warning">
                        <i class="fa fa-pencil"></i>
                    </Button>
                    <Button size="xs" @click="remove(item)" severity="error">
                        <i class="fa fa-trash"></i>
                    </Button>
                </ButtonGroup>
            </template>
        </DataTable>

        <ModuleForm
            v-if="showForm"
            v-model:show="showForm"
            :permissions="permissions"
            :statuses="statuses"
            :module="module" />

        <Alert
            @confirmed="destroy()"
            type="warning"
            title="Are you sure?"
            text="Do you want to delete this?"
            v-model:show="confirmed"
            confirm-button-type="error" />
    </AppLayout>
</template>

<style scoped></style>
