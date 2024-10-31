<script setup lang="ts">
import { dataGet } from "@/services/helper.service";
import { Column } from "@/types/datatable/column";

defineProps<{
    column: Column<any>;
    item: any;
}>();
</script>

<template>
    <template v-if="column.component">
        <component
            :is="column.component.el"
            v-bind="
                typeof column.component.props == 'function' ? column.component.props(item) : column.component.props
            ">
            {{ dataGet(item, column.field) ?? "-" }}
        </component>
    </template>
    <template v-else>
        {{ dataGet(item, column.field) ?? "-" }}
    </template>
</template>

<style scoped></style>
