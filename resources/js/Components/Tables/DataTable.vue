<script setup lang="ts">
import { Column } from "@/types/datatable/column.d";
import { computed, ref } from "vue";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Action } from "@/types/button";
import { Paginate } from "@/types/paginate";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { faArrowDown, faArrowUp } from "@fortawesome/free-solid-svg-icons";
import ArrowUpDown from "@/Components/Icon/ArrowUpDown.vue";
import _ from "lodash";
import DataValue from "@/Components/DataValue.vue";
import Select from "@/Components/Forms/Select.vue";
import Pagination from "@/Components/Tables/Pagination.vue";

const props = defineProps<{
    values: Array<any>;
    columns: Column<any>[];
    checkbox?: boolean;
    rowProps?: any;
    paginate?: Paginate<any> | undefined;
    actions?: Action[];
    root?: {
        actionClass?: string[] | string;
        checkBoxClass?: string[] | string;
    };
}>();

const emit = defineEmits<{
    showPage: [page: number];
    sort: [];
    search: [s: string];
    rowDbclick: [item: any];
}>();

const shows = [10, 20, 50, 100];

const showPerPage = ref(props.paginate?.per_page ?? 20);

const search = defineModel("search");

const checked = defineModel<Array<number>>("checked");

const checkedAll = computed<boolean>(() => {
    return checked.value?.length === props.values.length && props.values.length !== 0;
});

const selectRow = defineModel<any>("selectRow");

const sortBy = defineModel<any>("sortBy");

function changeCheckedAll(event: Event) {
    const input = event.target as HTMLInputElement;

    if (input.checked) {
        checked.value = props.values.map((item: any) => item.id);
    } else {
        checked.value = [];
    }
}

function sort(item: Column<any>) {
    if (!item.sortable) {
        return;
    }

    let direction;

    if (sortBy.value.field == item.sortable) {
        if (sortBy.value.direction == null) {
            direction = "asc";
        } else if (sortBy.value.direction == "asc") {
            direction = "desc";
        } else {
            direction = null;
        }
    } else {
        direction = "asc";
    }

    sortBy.value = { field: item.sortable, direction };
}

const inputSearch = _.debounce(function (e: Event) {
    emit("search", (e.target as HTMLInputElement).value);
}, 500);
</script>

<template>
    <div class="flex items-center px-2 py-4">
        <div class="flex">
            <div>
                <TextInput
                    @input="inputSearch"
                    :root="{ class: '!gap-2' }"
                    label="Filter:"
                    direction="horizontal"
                    v-model="search" />
            </div>
            <div>
                <slot name="filters" />
            </div>
        </div>

        <div class="ml-auto w-full max-w-xxs" v-if="paginate">
            <Select
                :show-search="false"
                label-inline
                label="Show:"
                :options="shows"
                id="show"
                @change="$emit('showPage', showPerPage)"
                v-model="showPerPage">
            </Select>
        </div>
    </div>
    <table class="min-w-full table-fixed border-collapse rounded-md xl:w-full">
        <!-- Headers -->
        <thead>
            <tr>
                <th
                    v-if="checkbox"
                    :class="root?.checkBoxClass ?? 'w-10'"
                    class="border border-gray-300 bg-gray-200 text-center align-middle dark:border-gray-600 dark:bg-gray-700">
                    <Checkbox @change="changeCheckedAll" :value="true" v-model:checked="checkedAll" />
                </th>
                <template v-for="column in columns">
                    <th
                        :class="[column.sortable ? 'cursor-pointer' : '']"
                        @click="sort(column)"
                        class="border border-gray-300 bg-gray-200 py-3 pl-2 text-left align-middle font-semibold dark:border-gray-600 dark:bg-gray-700"
                        v-bind="column.props">
                        <div class="flex items-center">
                            <span>
                                {{ column.label }}
                            </span>
                            <span class="ml-3 inline-flex" v-if="column.sortable">
                                <ArrowUpDown
                                    v-if="
                                        sortBy?.field != column.sortable || (sortBy?.field && sortBy?.direction == null)
                                    "
                                    class="size-3.5" />
                                <fa-icon
                                    v-if="sortBy?.field === column.sortable && sortBy?.direction == 'desc'"
                                    :icon="faArrowDown" />
                                <fa-icon
                                    v-if="sortBy?.field === column.sortable && sortBy.direction == 'asc'"
                                    :icon="faArrowUp" />
                            </span>
                        </div>
                    </th>
                </template>

                <th :class="root?.actionClass" class="column head w-40" v-if="$slots.actions">Actions</th>
            </tr>
        </thead>

        <!-- Rows -->
        <tbody>
            <template v-if="values.length">
                <tr v-for="item in values" class="group">
                    <td
                        v-if="checkbox"
                        :class="[selectRow?.id == item.id ? 'active' : '']"
                        class="border border-gray-300 bg-gray-200 text-center align-middle dark:border-gray-600 dark:bg-gray-800 group-hover:dark:bg-gray-700">
                        <Checkbox :value="item.id" v-model:checked="checked" />
                    </td>
                    <template v-for="column in columns">
                        <td
                            v-bind="rowProps"
                            @dblclick="$emit('row-dbclick', item)"
                            @click="selectRow = selectRow?.id == item.id ? null : item"
                            :class="[selectRow?.id == item.id ? 'active' : '']"
                            class="column">
                            <DataValue :item="item" :column="column" />
                        </td>
                    </template>
                    <td v-if="$slots.actions" :class="[selectRow?.id == item.id ? 'active' : '']" class="column">
                        <slot name="actions" :item="item"></slot>
                    </td>
                </tr>
            </template>

            <!-- Paginate -->
            <template v-if="values.length === 0">
                <tr>
                    <td class="column !py-4" :colspan="columns.length + ($slots.actions ? 2 : 1)">Empty Data</td>
                </tr>
            </template>
        </tbody>
    </table>
    <Pagination :values="values" :paginate="paginate" />
</template>

<style scoped lang="postcss">
:deep(.column) {
    @apply border border-gray-300 py-1.5 pl-2 text-left align-middle
    group-hover:bg-gray-200
    dark:border-gray-600
    dark:bg-gray-800
    group-hover:dark:bg-gray-700;
}

:deep(.column.head) {
    @apply dark:border-gray-600 dark:bg-gray-700;
}

:deep(.active) {
    @apply bg-gray-200 dark:bg-gray-700;
}
</style>
