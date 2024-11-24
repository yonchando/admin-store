<script setup lang="ts">
import { ColumnType } from "@/types/datatable/column.d";
import { computed, ref, useSlots } from "vue";
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
import Column from "@/Components/Tables/Column.vue";

const props = withDefaults(
    defineProps<{
        values?: Array<any>;
        columns?: ColumnType<any>[];
        checkbox?: boolean;
        rowProps?: any;
        paginate?: Paginate<any> | undefined;
        actions?: Action[];
        filter?: boolean;
        root?: {
            actionClass?: string[] | string;
            checkBoxClass?: string[] | string;
        };
    }>(),
    {
        checkbox: true,
        values: [] as any,
        columns: [] as any,
        filter: true,
    },
);

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

const inputSearch = _.debounce(function (e: Event) {
    emit("search", (e.target as HTMLInputElement).value);
}, 500);

const slots = useSlots();
const columnLength = computed(() => {
    return (
        props.columns.filter((item) => !item.hideFromIndex).length + (props.checkbox ? 1 : 0) + (slots.actions ? 1 : 0)
    );
});

function changeCheckedAll(event: Event) {
    const input = event.target as HTMLInputElement;

    if (input.checked) {
        checked.value = props.values.map((item: any) => item.id);
    } else {
        checked.value = [];
    }
}

function sort(item: ColumnType<any>) {
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

function rowSelected(item: any) {
    if (selectRow.value?.id === item.id) {
        selectRow.value = null;
    } else {
        selectRow.value = item;
    }
}
</script>

<template>
    <div class="flex items-center px-2 py-2">
        <div v-if="filter" class="flex">
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
            <tr v-if="!$slots.thead">
                <Column v-if="checkbox" :class="root?.checkBoxClass ?? 'w-10'" class="head px-0 py-2.5 text-center">
                    <Checkbox @change="changeCheckedAll" :value="true" v-model:checked="checkedAll" />
                </Column>
                <template v-for="column in columns">
                    <Column
                        :class="[column.sortable ? 'cursor-pointer' : '']"
                        @click="sort(column)"
                        class="head py-2.5"
                        v-if="!column.hideFromIndex"
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
                    </Column>
                </template>
                <Column :class="root?.actionClass" class="head w-40" v-if="$slots.actions">Actions</Column>
            </tr>

            <slot name="thead" />
        </thead>

        <!-- Rows -->
        <tbody>
            <slot name="tbody" />
            <template v-if="!$slots.tbody">
                <template v-if="values.length">
                    <tr v-for="(item, index) in values" class="group">
                        <Column
                            v-if="checkbox"
                            :class="[selectRow?.id == item.id ? 'active' : '']"
                            class="px-0 text-center">
                            <Checkbox :value="item.id" v-model:checked="checked" />
                        </Column>
                        <template v-for="column in columns">
                            <Column
                                v-if="!column.hideFromIndex"
                                v-bind="rowProps"
                                @dblclick="$emit('rowDbclick', item)"
                                @click="rowSelected(item)"
                                :class="[selectRow?.id === item.id ? 'active' : '']">
                                <DataValue :item="item" :column="column" :index="index" />
                            </Column>
                        </template>
                        <Column v-if="$slots.actions" :class="[selectRow?.id == item.id ? 'active' : '']">
                            <slot name="actions" :item="item"></slot>
                        </Column>
                    </tr>
                </template>

                <!-- Paginate -->
                <template v-if="values.length === 0">
                    <tr>
                        <Column class="py-3" :colspan="columnLength">Empty Data</Column>
                    </tr>
                </template>
            </template>
        </tbody>
    </table>
    <Pagination :values="values" :paginate="paginate" />
</template>

<style scoped></style>
