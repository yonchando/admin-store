<script setup lang="ts">
import { ColumnType } from "@/types/datatable/column";
import { PaginateMeta } from "@/types/paginate";
import TreeChild from "@/Components/TableTree/TreeChild.vue";
import DataTable from "@/Components/Tables/DataTable.vue";

defineProps<{
    columns: ColumnType<any>[];
    values?: any[];
    meta?: PaginateMeta;
}>();

const emit = defineEmits<{
    (e: "expand-child", child: any): void;
}>();
</script>

<template>
    <DataTable :columns="columns" :values="values" :meta="meta" :checkbox="false">
        <template #tbody>
            <TreeChild
                :padding-left="12"
                :padding-child="10"
                :columns="columns"
                :values="values"
                @expand-child="emit('expand-child', $event)" />
        </template>
    </DataTable>
</template>

<style scoped></style>
