<script setup lang="ts">
import { Column } from "@/types/datatable/column.d";
import { computed, ref } from "vue";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Action } from "@/types/button";

const props = withDefaults(
    defineProps<{
        values: any;
        columns: Column[];
        checkbox?: boolean;
        rowProps?: any;
        rowClick?: boolean;
        paginate: boolean;
        actions?: Action[];
    }>(),
    {
        paginate: true,
    },
);

defineEmits<{
    "update:checked": [item: Array<number>];
    page: [page: number];
}>();

const shows = [10, 20, 50, 100];

const showPerPage = ref(props.paginate ? props.values.per_page : 0);

const search = defineModel("search");

const data = computed(() => {
    return props.paginate ? props.values.data : props.values;
});

const checked = defineModel<Array<number>>("checked");

const checkedAll = computed<boolean>(() => {
    return checked.value?.length === data.value?.length && data.value?.length !== 0;
});

const selectRow = defineModel<any>("selected");

const selectedRows = ref<number | null>(null);

function changeCheckedAll(event: Event) {
    const input = event.target as HTMLInputElement;

    if (input.checked) {
        checked.value = data.value.map((item: any) => item.id);
    } else {
        checked.value = [];
    }
}
</script>

<template>
    <div class="flex px-2 py-4">
        <div>
            <TextInput :root="{ class: '!gap-2' }" label="Filter:" direction="horizontal" v-model="search" />
        </div>

        <div class="ml-auto inline-flex items-center gap-2" v-if="paginate">
            <label for="show">Show:</label>
            <div class="">
                <select
                    id="show"
                    class="w-full rounded-md bg-gray-700 text-gray-100"
                    @change="$emit('page', showPerPage)"
                    v-model="showPerPage">
                    <option v-for="show in shows" :value="show">{{ show }}</option>
                </select>
            </div>
        </div>
    </div>
    <div>
        <p v-if="!paginate">Total records: {{ data.length }}</p>
    </div>
    <table class="w-full table-auto border-collapse rounded-md">
        <tr>
            <th v-if="checkbox" class="w-10 border border-light-200 text-center dark:border-gray-700">
                <Checkbox @change="changeCheckedAll" :value="true" v-model:checked="checkedAll" />
            </th>
            <th v-for="column in columns" class="border border-gray-700 py-1.5 pl-1.5 text-left" v-bind="column.props">
                {{ column.label }}
            </th>
            <th class="w-40 border border-gray-700 py-1.5 pl-1.5 text-left" v-if="actions">Action</th>
        </tr>

        <template v-if="data.length">
            <tr v-for="item in data" class="group">
                <td
                    v-if="checkbox"
                    :class="[selectRow?.id == item.id ? 'bg-gray-700' : '']"
                    class="border border-light-200 text-center group-hover:bg-gray-700 dark:border-gray-700">
                    <Checkbox :value="item.id" v-model:checked="checked" />
                </td>
                <template v-for="column in columns">
                    <td
                        v-bind="rowProps"
                        @click="selectRow = selectRow?.id == item.id ? null : item"
                        :class="[selectRow?.id == item.id ? 'bg-gray-700' : '']"
                        class="border border-dark-700 py-1.5 pl-1.5 text-left group-hover:bg-gray-700">
                        <template v-if="column.component">
                            <component
                                :is="column.component.el"
                                v-bind="column.component.props"
                                v-html="column.component.label">
                            </component>
                        </template>
                        <template v-else>
                            <template v-if="typeof column.field === 'string'">
                                {{ item[column.field] ?? "-" }}
                            </template>
                            <template v-else>
                                {{ column.field ? column.field(item) : "-" }}
                            </template>
                        </template>
                    </td>
                </template>
            </tr>
        </template>

        <template v-if="data.length === 0">
            <tr>
                <td
                    class="border border-light-200 py-3 pl-4 text-left group-hover:bg-dark-700 dark:border-dark-700"
                    :colspan="columns.length + 1">
                    Empty Data
                </td>
            </tr>
        </template>
    </table>
    <div class="px-2 py-4">
        <p v-if="paginate">Showing to 10 of 15 entries</p>
    </div>
</template>
