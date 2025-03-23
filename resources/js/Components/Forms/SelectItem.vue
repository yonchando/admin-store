<script setup lang="ts">
const props = defineProps<{
    data: Array<any>;
    multiple?: boolean;
}>();

const model = defineModel();

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

function isSelected(option: any) {
    if (props.multiple) {
        const values = (model.value as Array<any>) ?? [];
        return values.includes(get(option, "optionValue"));
    } else {
        return get(option, "optionValue") == model.value;
    }
}

function setModel(option: any) {
    if (props.multiple) {
        const values = model.value as Array<any>;

        if (props.maxSelected && values.length > props.maxSelected) {
            return;
        }

        const index = values.findIndex((item) => item === get(option, "optionValue"));

        if (index != -1) {
            values.splice(index, 1);
        } else {
            values?.push(get(option, "optionValue"));
        }
    } else {
        model.value = get(option, "optionValue");
        open.value = false;
    }

    emit("change", option);
}
</script>

<template>
    <template v-if="data.length > 0">
        <template v-for="option in data">
            <div
                @click="setModel(option)"
                class="flex cursor-pointer items-center py-3.5 pl-4 text-left hover:bg-gray-200 dark:hover:bg-gray-900">
                <div class="min-w-5">
                    <i v-show="isSelected(option)" class="fa fa-check text-xxs"></i>
                </div>
                <span class="text-capitalize">
                    {{ get(option, "optionLabel") }}
                </span>
            </div>
        </template>
    </template>
</template>

<style scoped></style>
