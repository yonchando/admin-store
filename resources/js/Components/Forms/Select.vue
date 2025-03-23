<script setup lang="ts">
import { computed, nextTick, ref, watchEffect } from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import _ from "lodash";
import TextInput from "@/Components/Forms/TextInput.vue";
import Badge from "@/Components/Badges/Badge.vue";
import { PaginateMeta } from "@/types/paginate";

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
        dropdownClass?: string;
        loading?: boolean;
        meta?: PaginateMeta;
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
        dropdownClass: "fixed",
    },
);

const emit = defineEmits<{
    (e: "change", option: any): void;
    (e: "open"): void;
    (e: "search", search: string): void;
    (e: "loadMore", page: number): void;
}>();

let data = computed(() => {
    return storeOptions.value;
});

const model = defineModel();

const loading = defineModel("loading");

const dropdown = ref();

const open = ref(false);

const selected = computed(() => {
    if (props.multiple) {
        const values = (model.value as Array<any>) ?? [];
        return data.value
            .filter((item, i) => {
                return values?.includes(get(item, "optionValue")) && (props.maxShow == undefined || i < props.maxShow);
            })
            .map((item) => {
                return get(item, "optionLabel");
            });
    }

    if (_.isArray(data.value)) {
        let item = data.value.find((item) => {
            return get(item, "optionValue") == model.value;
        });

        return get(item, "optionLabel");
    }

    if (_.isObject(data.value)) {
        return get(data.value, "optionLabel");
    }
});

const search = ref<string>("");

const inputSearch = ref<HTMLInputElement | null>(null);

const minWidth = ref<number>(0);

const storeOptions = ref(props.options);

watchEffect(() => {
    storeOptions.value = props.options;

    if (open) {
        emit("open");

        minWidth.value = dropdown.value?.clientWidth ?? 0;

        document.addEventListener("keydown", closeOnEscape);
        document.addEventListener("click", closeOnClickOutside);
    } else {
        document.removeEventListener("keydown", closeOnEscape);
        document.removeEventListener("click", closeOnClickOutside);
    }
});

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

function openToggle() {
    open.value = !open.value;

    nextTick(() => {
        inputSearch.value?.focus();
    });
}

function closeOnEscape(e: KeyboardEvent) {
    if (open.value && e.key === "Escape") {
        open.value = false;
    }
}

function closeOnClickOutside(e: MouseEvent) {
    if (!dropdown.value?.contains(e.target as HTMLElement)) {
        open.value = false;
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

function isSelected(option: any) {
    if (props.multiple) {
        const values = (model.value as Array<any>) ?? [];
        return values.includes(get(option, "optionValue"));
    } else {
        return get(option, "optionValue") == model.value;
    }
}

const timeoutId = ref<NodeJS.Timeout>();
function searching() {
    if (timeoutId.value) {
        clearTimeout(timeoutId.value);
    }

    timeoutId.value = setTimeout(() => {
        emit("search", search.value);
    }, 1000);
}
</script>

<template>
    <div :class="[labelInline ? 'flex items-center' : 'flex flex-col']" class="w-full flex-1 gap-2">
        <InputLabel v-if="label" :value="label" />
        <span v-else></span>

        <div
            class="relative w-full focus-visible:outline-gray-800 focus-visible:ring-transparent"
            :tabindex="tabindex"
            ref="dropdown">
            <div class="relative w-full">
                <div class="form-select" @click="openToggle">
                    <span v-if="selected === undefined || selected.length === 0" class="placeholder">
                        Select option
                    </span>
                    <span v-else class="flex items-center gap-2">
                        <template v-if="props.multiple">
                            <template v-for="label in selected">
                                <Badge severity="info">{{ label }}</Badge>
                            </template>
                            <Badge severity="secondary" v-if="(model as []).length > maxShow">
                                ({{ (model as []).length - maxShow }} more)
                            </Badge>
                        </template>
                        <template v-if="!props.multiple">
                            {{ selected }}
                        </template>
                    </span>
                </div>
            </div>

            <Transition
                enter-active-class="transition-[max-height,opacity] ease-in-out duration-100 overflow-hidden"
                enter-from-class="max-h-0 opacity-0"
                enter-to-class="max-h-96 opacity-100"
                leave-active-class="transition-all ease-in-out duration-100 overflow-hidden"
                leave-from-class="max-h-96 opacity-100"
                leave-to-class="max-h-0 opacity-0">
                <div
                    v-show="open"
                    :style="[minWidth ? `min-width: ${minWidth}px` : '']"
                    :class="dropdownClass"
                    class="z-40 mt-2 rounded-md bg-gray-50 py-2 shadow-lg dark:bg-gray-700">
                    <div class="mb-2 px-2" v-if="showSearch">
                        <TextInput @input="searching" v-model="search" ref="inputSearch" />
                    </div>
                    <div class="max-h-80 overflow-auto" ref="selectContent">
                        <template v-if="loading">
                            <div class="absolute inset-0 bg-black/25">
                                <div role="status" class="absolute left-1/2 top-2/4 -translate-x-1/2 -translate-y-1/2">
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
                                </div>
                            </div>
                        </template>

                        <div class="flex flex-shrink-0 flex-grow-0 flex-col">
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
                            <div
                                v-if="data.length === 0 && !loading"
                                class="flex cursor-pointer items-center py-3.5 pl-4 text-left hover:bg-gray-200 dark:hover:bg-gray-900">
                                <div class="min-w-5"></div>
                                <span class="text-capitalize"> No option </span>
                            </div>
                        </div>
                    </div>

                    <template v-if="meta">
                        <div v-if="meta.current_page < meta?.last_page" class="mt-2 flex px-2">
                            <button
                                @click="emit('loadMore', meta.current_page + 1)"
                                type="button"
                                class="inline-flex w-full items-center justify-center rounded bg-gray-800 py-3 text-center hover:bg-gray-800/85">
                                View more
                            </button>
                        </div>
                    </template>
                </div>
            </Transition>
        </div>
    </div>
</template>

<style scoped></style>
