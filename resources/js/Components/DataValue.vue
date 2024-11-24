<script setup lang="ts">
import { dataGet } from "@/services/helper.service";
import { ColumnType } from "@/types/datatable/column";
import { computed } from "vue";

const props = defineProps<{
    column: ColumnType<any>;
    item: any;
    index: any;
}>();

const binding = computed(() => {
    if (typeof props.column.component?.props == "function") {
        return props.column.component?.props(props.item, props.index);
    } else {
        return props.column.component?.props;
    }
});
</script>

<template>
    <template v-if="column.component">
        <component :is="column.component.el" v-bind="binding">
            {{ dataGet(item, column?.field as any) ?? "-" }}
        </component>
    </template>
    <template v-else>
        {{ dataGet(item, column?.field as any) ?? "-" }}
    </template>
</template>

<style scoped></style>
