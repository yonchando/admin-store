<script setup>
const props = defineProps({
    columns: {
        type: Array,
        required: true
    },
    loading: Boolean,
    data: Array
});
</script>

<template>
    <DataTable
        selection-mode="multiple"
        :loading="loading"
        :value="data"
        filter-display="menu"
        size="small"
    >
        <Column selection-mode="multiple" class="w-12" />
        <template v-for="column in columns">
            <template v-if="column.component">
                <Column v-bind="column">
                    <template #body="slotProps">
                        <component :is="column.component" v-bind="column.props(slotProps)"/>
                    </template>
                </Column>
            </template>
            <template v-else>
                <Column v-bind="column"/>
            </template>
        </template>
    </DataTable>
</template>

<style scoped>

</style>