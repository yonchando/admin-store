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
import { router } from "@inertiajs/vue3";
import ArrowUpDown from "@/Components/Icon/ArrowUpDown.vue";
import _ from "lodash";

const props = defineProps<{
    values: Array<any>;
    columns: Column[];
    checkbox?: boolean;
    rowProps?: any;
    paginate?: Paginate<any>;
    actions?: Action[];
}>();

const emit = defineEmits<{
    page: [page: number];
    sort: [];
    search: [s: string];
}>();

const shows = [10, 20, 50, 100];

const showPerPage = ref(props.paginate?.per_page ?? 20);

const search = defineModel("search");

const checked = defineModel<Array<number>>("checked");

const checkedAll = computed<boolean>(() => {
    return checked.value?.length === props.values.length && props.values.length !== 0;
});

const selectRow = defineModel<any>("selected");

const sortable = defineModel<any>("sortable");

function changeCheckedAll(event: Event) {
    const input = event.target as HTMLInputElement;

    if (input.checked) {
        checked.value = props.values.map((item: any) => item.id);
    } else {
        checked.value = [];
    }
}

function sort(item: Column) {
    let direction;

    if (sortable.value.field == item.field) {
        if (sortable.value.direction == null) {
            direction = "asc";
        } else if (sortable.value.direction == "asc") {
            direction = "desc";
        } else {
            direction = null;
        }
    } else {
        direction = "asc";
    }

    sortable.value = { field: item.field, direction };
}

const inputSearch = _.debounce(function (e: Event) {
    emit("search", (e.target as HTMLInputElement).value);
}, 500);
</script>

<template>
    <div class="flex px-2 py-4">
        <div>
            <TextInput
                @input="inputSearch"
                :root="{ class: '!gap-2' }"
                label="Filter:"
                direction="horizontal"
                v-model="search" />
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
    <div class="mb-4">
        <p>Total: {{ paginate ? paginate.total : values.length }}</p>
    </div>
    <table class="w-full table-auto border-collapse rounded-md">
        <tr>
            <th v-if="checkbox" class="border-light-200 w-10 border text-center dark:border-gray-700">
                <Checkbox @change="changeCheckedAll" :value="true" v-model:checked="checkedAll" />
            </th>
            <th
                v-for="column in columns"
                :class="[column.sortable ? 'cursor-pointer' : '']"
                @click="sort(column)"
                class="border border-gray-700 py-3 pl-2 text-left align-middle"
                v-bind="column.props">
                <div class="flex">
                    {{ column.label }}
                    <span class="ml-4 mr-2 inline-flex" v-if="column.sortable">
                        <ArrowUpDown
                            v-if="sortable.field != column.field || (sortable.field && sortable.direction == null)"
                            class="size-3.5" />
                        <fa-icon
                            v-if="sortable.field === column.field && sortable.direction == 'asc'"
                            :icon="faArrowDown" />
                        <fa-icon
                            v-if="sortable.field === column.field && sortable.direction == 'desc'"
                            :icon="faArrowUp" />
                    </span>
                </div>
            </th>
            <th class="w-40 border border-gray-700 py-3 pl-2 text-left" v-if="actions">Action</th>
        </tr>

        <template v-if="values.length">
            <tr v-for="item in values" class="group">
                <td
                    v-if="checkbox"
                    :class="[selectRow?.id == item.id ? 'bg-gray-700' : '']"
                    class="border-light-200 border text-center group-hover:bg-gray-700 dark:border-gray-700">
                    <Checkbox :value="item.id" v-model:checked="checked" />
                </td>
                <template v-for="column in columns">
                    <td
                        v-bind="rowProps"
                        @click="selectRow = selectRow?.id == item.id ? null : item"
                        :class="[selectRow?.id == item.id ? 'bg-gray-700' : '']"
                        class="border border-gray-700 py-3 pl-2 text-left align-middle group-hover:bg-gray-700">
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

        <template v-if="values.length === 0">
            <tr>
                <td
                    class="border-light-200 border py-3 pl-4 text-left group-hover:bg-gray-700 dark:border-gray-700"
                    :colspan="columns.length + 1">
                    Empty Data
                </td>
            </tr>
        </template>
    </table>
    <div class="flex items-center px-2 py-4">
        <template v-if="paginate?.data.length">
            <p>Showing: {{ paginate.current_page }} of {{ paginate.last_page }} pages</p>

            <div class="ml-auto flex">
                <template v-for="(link, index) in paginate.links">
                    <Button
                        @click="router.get(link.url)"
                        v-if="index == 0"
                        :disabled="!link.url"
                        class="rounded-s-full border-r-0 !px-3">
                        <fa-icon :icon="faAngleDoubleLeft"></fa-icon>
                        Previous
                    </Button>
                    <template v-if="index != 0 && index != paginate.links.length - 1">
                        <Button
                            :severity="link.active ? 'info' : 'primary'"
                            @click="router.get(link.url)"
                            class="rounded-none border-0 border-l">
                            {{ link.label }}
                        </Button>
                    </template>
                    <Button
                        @click="router.get(link.url)"
                        v-if="index == paginate.links.length - 1"
                        :disabled="!link.url"
                        class="rounded-e-full border-l-0 !px-3">
                        Next
                        <fa-icon :icon="faAngleDoubleRight"></fa-icon>
                    </Button>
                </template>
            </div>
        </template>
    </div>
</template>
