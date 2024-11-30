<script setup lang="ts">
import { ColumnType } from "@/types/datatable/column.d";
import { computed, reactive, useSlots } from "vue";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Action } from "@/types/button";
import { Paginate } from "@/types/paginate";
import _ from "lodash";
import DataValue from "@/Components/DataValue.vue";
import Select from "@/Components/Forms/Select.vue";
import Pagination from "@/Components/Tables/Pagination.vue";
import Column from "@/Components/Tables/Column.vue";
import { FilterData, Filters } from "@/types/datatable/datatable";
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
import Button from "@/Components/Button.vue";
import { callable, dataGet } from "@/services/helper.service";

const props = withDefaults(
    defineProps<{
        values?: Array<any>;
        columns?: ColumnType<any>[];
        checkbox?: boolean;
        rowProps?: any;
        paginate?: Paginate<any> | undefined;
        actions?: Action[];
        showSearch?: boolean;
        filtersData?: FilterData;
        filters?: object;
        root?: {
            actionClass?: string[] | string;
            checkBoxClass?: string[] | string;
            rowClass?: string[] | string;
        };
    }>(),
    {
        checkbox: true,
        values: [] as any,
        columns: [] as any,
        showSearch: true,
    },
);

const emit = defineEmits(["search", "rowDbclick", "filters"]);

const slots = useSlots();
const columnLength = computed(() => {
    return (
        props.columns.filter((item) => !item.hideFromIndex).length + (props.checkbox ? 1 : 0) + (slots.actions ? 1 : 0)
    );
});

const loading = defineModel("loading");

const shows = [10, 20, 50, 100];

const search = defineModel("search");

const checked = defineModel<Array<number>>("checked");

const checkedAll = computed<boolean>(() => {
    return checked.value?.length === props.values.length && props.values.length !== 0;
});

const filters: Filters = reactive({
    perPage: props.paginate?.per_page ?? 20,
    page: 1,
    sortBy: {
        field: "",
        direction: "-1",
    },
    ...props.filters,
});

const inputSearch = _.debounce(function (e: Event) {
    emit("search", (e.target as HTMLInputElement).value);
}, 500);

const directionIs = computed(() => {
    return (sortBy: any, direction: string | null) => {
        if (direction === null) {
            return sortBy !== filters.sortBy.field;
        }

        return filters.sortBy.field === sortBy && filters.sortBy.direction === direction;
    };
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

    let directions: any = {
        "-1": "asc",
        asc: "desc",
        desc: "-1",
    };

    if (filters.sortBy.field == item.sortable) {
        direction = directions[filters.sortBy.direction];
    } else {
        direction = "asc";
    }

    if (direction !== "-1") {
        filters.sortBy = { field: item.sortable, direction: direction as "asc" | "desc" };
    } else {
        filters.sortBy = { field: null, direction: "-1" };
    }

    emit("filters", filters);
}

function changeRows() {
    emit("filters", filters);
}

function applyFilters(callback: any) {
    emit("filters", filters);
    callback();
}

function clearFilter(callback: any, field: string) {
    filters[field] = "";
    emit("filters", filters);
    callback();
}
</script>

<template>
    <div class="flex items-center py-2">
        <div v-if="showSearch" class="flex">
            <div>
                <TextInput
                    @input="inputSearch"
                    :root="{ class: '!gap-2' }"
                    direction="horizontal"
                    placeholder="Search..."
                    v-model="search" />
            </div>
        </div>

        <div class="ml-auto w-full max-w-xxs" v-if="paginate">
            <Select
                :show-search="false"
                label-inline
                label="Show:"
                :options="shows"
                id="show"
                @change="changeRows"
                v-model="filters.perPage">
            </Select>
        </div>
    </div>
    <div class="relative">
        <div v-if="loading" class="absolute inset-0 bg-slate-100/50 dark:bg-gray-700/50">
            <div role="status" class="flex h-full max-h-screen w-full items-center justify-center">
                <svg
                    aria-hidden="true"
                    class="h-8 w-8 animate-spin fill-blue-600 text-gray-200 dark:text-gray-600"
                    viewBox="0 0 100 101"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <table class="min-w-full table-fixed border-collapse rounded-md xl:w-full">
            <!-- Headers -->
            <thead>
                <tr v-if="!$slots.thead">
                    <Column
                        v-if="checkbox"
                        :class="root?.checkBoxClass ?? 'w-10'"
                        class="head max-w-10 px-0 py-2.5 text-center">
                        <Checkbox @change="changeCheckedAll" :value="true" v-model:checked="checkedAll" />
                    </Column>
                    <template v-for="column in columns">
                        <Column class="head" v-if="!column.hideFromIndex" v-bind="column.props">
                            <div class="flex items-center">
                                <span>
                                    {{ column.label }}
                                </span>
                                <span
                                    :class="[column.sortable ? 'cursor-pointer' : '']"
                                    @click="sort(column)"
                                    class="ml-3 inline-flex"
                                    v-if="column.sortable">
                                    <i v-if="directionIs(column.sortable, null)" class="fa fa-sort"></i>
                                    <i v-if="directionIs(column.sortable, 'asc')" class="fa fa-sort-up"></i>
                                    <i v-if="directionIs(column.sortable, 'desc')" class="fa fa-sort-down"></i>
                                </span>
                                <span class="ml-auto" v-if="column.filters">
                                    <Dropdown content-width="250" :position="{ left: -230, top: 18 }">
                                        <template #trigger>
                                            <span class="relative text-base">
                                                <i
                                                    v-if="!filters[column.filters.field]"
                                                    class="fa fa-filter text-base"></i>
                                                <i
                                                    v-if="filters[column.filters.field]"
                                                    class="fa fa-filter-circle-xmark"></i>
                                            </span>
                                        </template>

                                        <template #content="{ close }">
                                            <div class="flex flex-col gap-4 px-4 py-2">
                                                <div>
                                                    <component
                                                        :is="column.filters.component.el"
                                                        v-model="filters[column.filters.field]"
                                                        v-bind="callable(column.filters.component.props, props)" />
                                                </div>
                                                <div class="ml-auto flex gap-3">
                                                    <Button @click="applyFilters(close)" severity="info" size="sm">
                                                        Apply
                                                    </Button>
                                                    <Button
                                                        @click="clearFilter(close, column.filters.field)"
                                                        severity="secondary"
                                                        size="sm">
                                                        Clear
                                                    </Button>
                                                </div>
                                            </div>
                                        </template>
                                    </Dropdown>
                                </span>
                            </div>
                        </Column>
                    </template>
                    <Column :class="root?.actionClass" class="head w-32" v-if="$slots.actions">Actions</Column>
                </tr>

                <slot name="thead" />
            </thead>

            <!-- Rows -->
            <tbody>
                <slot name="tbody" />
                <template v-if="!$slots.tbody">
                    <template v-if="values.length">
                        <tr v-for="(item, index) in values" class="group">
                            <Column v-if="checkbox" class="px-0 text-center">
                                <Checkbox :value="item.id" v-model:checked="checked" />
                            </Column>
                            <template v-for="column in columns">
                                <Column
                                    v-if="!column.hideFromIndex"
                                    v-bind="rowProps"
                                    @dblclick="$emit('rowDbclick', item)"
                                    :class="[...(root?.rowClass ?? '')]">
                                    <DataValue :item="item" :column="column" :index="index" />
                                </Column>
                            </template>
                            <Column v-if="$slots.actions">
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
    </div>
    <Pagination :values="values" :paginate="paginate" @page="loading = true" />
</template>

<style scoped></style>
