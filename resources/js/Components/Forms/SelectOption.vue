<script setup lang="ts">
import _ from "lodash";

const props = withDefaults(
    defineProps<{
        label?: string;
        options?: Array<any>;
        optionValue?: any;
        optionLabel?: any;
        placeholder?: string;
        showSearch?: boolean;
        labelInline?: boolean;
        tabindex?: number | string;
        multiple?: boolean;
        maxSelected?: number;
        maxShow?: number;
        hasMorePage?: boolean;
        id: string;
    }>(),
    {
        optionValue: "id",
        optionLabel: "name",
        showSearch: true,
        labelInline: false,
        tabindex: -1,
        multiple: false,
        maxShow: undefined,
        options: [] as any,
        id: "selectOption",
    },
);

function get(option: any, type: "optionValue" | "optionLabel") {
    if (typeof props[type] === "string") {
        if (!_.isObject(option)) {
            return option;
        }
        return _.get(option, props[type]);
    } else {
        return props[type](option);
    }
}
</script>

<template>
    <div class="form-select">
        <button :data-dropdown-toggle="id" class="form-select-btn" type="button">
            <span>Select option</span>
        </button>

        <!-- Dropdown menu -->
        <div :id="id" class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li v-for="option in options" :key="option.id">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        {{ get(option, "optionLabel") }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped></style>
