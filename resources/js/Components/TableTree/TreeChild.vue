<script setup lang="ts">
import Column from "@/Components/Tables/Column.vue";
import DataValue from "@/Components/DataValue.vue";
import { ColumnType } from "@/types/datatable/column";
import { PaginateMeta } from "@/types/paginate";

defineProps<{
    columns: ColumnType<any>[];
    values?: any[];
    meta?: PaginateMeta;
    paddingLeft: number;
}>();

const emit = defineEmits<{
    (e: "expand-child", child: any): void;
}>();
</script>

<template>
    <template v-for="(item, i) in values">
        <tr>
            <template v-for="(column, j) in columns">
                <template v-if="j === 0">
                    <Column class="py-3" :style="{ 'padding-left': paddingLeft + 'px' }">
                        <template v-if="item.children_count">
                            <span class="mr-2 cursor-pointer" @click="emit('expand-child', item)">
                                <i v-if="!item.open" class="fa fa-chevron-right"></i>
                                <i v-if="item.open" class="fa fa-chevron-down"></i>
                            </span>
                        </template>

                        <DataValue :item="item" :column="column" :index="i" />
                    </Column>
                </template>

                <Column v-else class="py-3">
                    <DataValue :item="item" :column="column" :index="i" />
                </Column>
            </template>
        </tr>

        <template v-if="item.open">
            <TreeChild
                :columns="columns"
                :values="item.children"
                :padding-left="paddingLeft + 24"
                @expand-child="emit('expand-child', $event)" />
        </template>
    </template>
</template>

<style scoped></style>
