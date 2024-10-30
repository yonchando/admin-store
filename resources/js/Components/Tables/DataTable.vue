<script setup lang="ts">
import { Column } from "@/types/datatable/column.d";
import { computed, ref } from "vue";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Action } from "@/types/button";
import { Paginate } from "@/types/paginate";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { faAngleDoubleLeft, faAngleDoubleRight, faArrowDown, faArrowUp } from "@fortawesome/free-solid-svg-icons";
import Button from "@/Components/Button.vue";
import ArrowUpDown from "@/Components/Icon/ArrowUpDown.vue";
import _ from "lodash";
import { router } from "@inertiajs/vue3";
import DataValue from "@/Components/DataValue.vue";

const props = defineProps<{
    values: Array<any>;
    columns: Column<any>[];
    checkbox?: boolean;
    rowProps?: any;
    paginate?: Paginate<any>;
    actions?: Action[];
}>();

const emit = defineEmits<{
    page: [page: number];
    sort: [];
    search: [s: string];
    "row-dbclick": [item: any];
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

function sort(item: Column) {
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

function get(item, key: string | ((t: type) => string)) {
    if (typeof key === "string") {
        return _.get(item, key);
    } else {
        return key(item);
    }
}
</script>

<template>
    <div class="flex px-2 py-4">
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
    <table class="w-full table-fixed border-collapse rounded-md">
        <tr>
            <th
                v-if="checkbox"
                class="w-10 border border-gray-300 bg-gray-200 text-center align-middle dark:border-gray-600 dark:bg-gray-700">
                <Checkbox @change="changeCheckedAll" :value="true" v-model:checked="checkedAll" />
            </th>
            <th
                v-for="column in columns"
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
                            v-if="sortBy?.field != column.sortable || (sortBy?.field && sortBy?.direction == null)"
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
            <th
                class="w-40 border border-gray-200 bg-gray-200 py-3 pl-2 text-left align-middle dark:border-gray-600 dark:bg-gray-800"
                v-if="$slots.actions">
                Actions
            </th>
        </tr>

        <template v-if="values.length">
            <tr v-for="item in values" class="group">
                <td
                    v-if="checkbox"
                    :class="[selectRow?.id == item.id ? 'bg-gray-200 dark:bg-gray-700' : 'dark:bg-gray-800']"
                    class="column">
                    <Checkbox :value="item.id" v-model:checked="checked" />
                </td>
                <template v-for="column in columns">
                    <td
                        v-bind="rowProps"
                        @dblclick="$emit('row-dbclick', item)"
                        @click="selectRow = selectRow?.id == item.id ? null : item"
                        :class="[selectRow?.id == item.id ? 'bg-gray-200 dark:bg-gray-700' : 'dark:bg-gray-800']"
                        class="column">
                        <DataValue :item="item" :column="column" />
                    </td>
                </template>
                <td
                    v-if="$slots.actions"
                    :class="[selectRow?.id == item.id ? 'bg-gray-200 dark:bg-gray-700' : 'dark:bg-gray-800']"
                    class="column">
                    <slot name="actions" :item="item"></slot>
                </td>
            </tr>
        </template>

        <template v-if="values.length === 0">
            <tr>
                <td class="column !py-4" :colspan="columns.length + ($slots.actions ? 2 : 1)">Empty Data</td>
            </tr>
        </template>
    </table>
    <div class="flex items-center px-2 py-4">
        <template v-if="paginate?.data.length">
            <div class="flex gap-4">
                <p class="">
                    Total:
                    <span class="font-semibold">
                        {{ paginate ? paginate.total : values.length }}
                    </span>
                </p>
                <p>
                    Showing:
                    <span class="font-semibold">
                        {{ paginate.current_page }} of
                        {{ paginate.last_page }}
                        pages
                    </span>
                </p>
            </div>

            <div class="ml-auto flex" v-if="paginate.links.length > 0">
                <template v-for="(link, index) in paginate.links">
                    <template v-if="index == 0">
                        <Button
                            @click="router.get(link.url)"
                            :disabled="!link.url"
                            class="rounded-s-full border-r-0 !px-3">
                            <fa-icon :icon="faAngleDoubleLeft"></fa-icon>
                            Previous
                        </Button>
                    </template>
                    <template v-if="index != 0 && index != paginate.links.length - 1">
                        <Button
                            v-if="link.url"
                            :severity="link.active ? 'info' : 'secondary'"
                            @click="router.get(link.url)"
                            class="rounded-none border-l-0">
                            {{ link.label }}
                        </Button>
                        <Button v-else class="rounded-none border-l-0" severity="secondary">
                            {{ link.label }}
                        </Button>
                    </template>
                    <template v-if="index == paginate.links.length - 1">
                        <Button
                            @click="router.get(link.url)"
                            :disabled="!link.url"
                            class="rounded-e-full border-l-0 !px-3">
                            Next
                            <fa-icon :icon="faAngleDoubleRight"></fa-icon>
                        </Button>
                    </template>
                </template>
            </div>
        </template>
    </div>
</template>

<style scoped>
.column {
    @apply border border-gray-300 py-1.5 pl-2 text-left align-middle group-hover:bg-gray-200 dark:border-gray-600 group-hover:dark:bg-gray-700;
}
</style>
