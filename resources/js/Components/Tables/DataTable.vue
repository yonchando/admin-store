<script setup lang="ts">
import { Column } from "@/types/datatable/column.d";
import { computed, ref } from "vue";
import { Paginate } from "@/types/paginate";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps<{
    values: any;
    columns: Column<any>[];
    checkbox?: boolean;
}>();

const emit = defineEmits<{
    "update:checked": [item: Array<number>];
    selectRow: [item: any];
}>();

const data = computed(() => {
    return props.values.data ?? (props.values as Paginate<any>).data;
});

const checked = defineModel<Array<number>>("checked");

const checkedAll = computed<boolean>(() => {
    return checked.value?.length === data.value?.length;
});

const selectedRow = ref<number | null>(null);

function changeCheckedAll(event: Event) {
    const input = event.target as HTMLInputElement;

    if (input.checked) {
        checked.value = data.value.map((item: any) => item.id);
    } else {
        checked.value = [];
    }
}

function selectRow(item: any) {
    if (selectedRow.value === item.id) {
        selectedRow.value = null;
        return;
    }

    selectedRow.value = item.id;

    emit("selectRow", item);
}
</script>

<template>
    <table class="w-full table-auto border-collapse rounded-md">
        <tr>
            <th v-if="checkbox" class="w-10 border border-light-200 text-center dark:border-dark-700">
                <Checkbox @change="changeCheckedAll" :value="true" v-model:checked="checkedAll" />
            </th>
            <th v-for="column in columns" class="border border-dark-700 py-1.5 pl-1.5 text-left" v-bind="column.props">
                {{ column.label }}
            </th>
        </tr>

        <tr v-for="item in data" class="group">
            <td
                v-if="checkbox"
                :class="[selectedRow == item.id ? 'bg-dark-700' : '']"
                class="border border-light-200 text-center group-hover:bg-dark-700 dark:border-dark-700">
                <Checkbox :value="item.id" v-model:checked="checked" />
            </td>
            <template v-for="column in columns">
                <td
                    @click="selectRow(item)"
                    :class="[selectedRow == item.id ? 'bg-dark-700' : '']"
                    class="border border-dark-700 py-1.5 pl-1.5 text-left group-hover:cursor-pointer group-hover:bg-dark-700">
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
    </table>
</template>
