<script setup lang="ts">
import { computed, nextTick, onMounted, onUnmounted, reactive, ref, watch } from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { faChevronDown, faTimes } from "@fortawesome/free-solid-svg-icons";
import _, { drop } from "lodash";
import TextInput from "@/Components/Forms/TextInput.vue";
import axios from "axios";
import { Paginate } from "@/types/paginate";
import Badge from "@/Components/Badges/Badge.vue";

const props = withDefaults(
    defineProps<{
        label?: string;
        options?: Array<any>;
        optionValue?: any;
        optionLabel?: any;
        placeholder?: string;
        url?: string;
        showSearch?: boolean;
        paginate?: Paginate<any>;
        labelInline: boolean;
        tabindex: number | string;
        multiple?: boolean;
        maxSelected?: number;
        maxShow?: number;
    }>(),
    {
        optionValue: "id",
        optionLabel: "name",
        showSearch: true,
        labelInline: false,
        tabindex: -1,
        multiple: false,
        maxShow: undefined,
    },
);

const emit = defineEmits<{
    change: [item: any];
}>();

const data = ref<Array<any>>(props.options ?? []);

const model = defineModel();

const inputClass = [
    "flex justify-between items-center",
    "w-full",
    "px-4 py-2",
    "cursor-pointer",
    "rounded-md",
    "border",
    "border-gray-200",
    "focus:border-gray-300 focus:ring-gray-300",
    "text-sm",
    "dark:border-gray-700",
    "dark:bg-gray-900",
    "dark:text-gray-300",
    "dark:focus:border-gray-700 dark:focus:ring-gray-700",
];

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

    let item = data.value.find((item) => {
        return get(item, "optionValue") === model.value;
    });

    return get(item, "optionLabel");
});

const search = ref<string>("");

const inputSearch = ref<HTMLInputElement | null>(null);

const page = reactive({
    current_page: props.paginate?.current_page ?? 2,
    last_page: props.paginate?.last_page ?? 0,
});

const processing = ref(false);
const searching = _.debounce(
    () => {
        if (!props.url) {
            data.value =
                props.options?.filter((item: any) => {
                    return get(item, "optionLabel").toLowerCase().startsWith(search.value.toLowerCase());
                }) ?? [];
        } else {
            fetchData({
                search: search.value,
            }).then((res: any) => {
                const v = res.data;

                data.value = v.data;

                if (res.data.meta) {
                    page.current_page = v.meta.current_page;
                    page.last_page = v.meta.last_page;
                } else {
                    page.last_page = 0;
                }
            });
        }
    },
    props.url ? 500 : 0,
);

const minWidth = computed(() => {
    const el = dropdown.value as HTMLElement;

    return el?.clientWidth ?? 0;
});

function get(option: any, type: "optionValue" | "optionLabel") {
    if (!_.isObject(option)) {
        return option;
    }

    if (typeof props[type] === "string") {
        return _.get(option, props[type]);
    } else {
        return props[type](option);
    }
}

function fetchData(params = {}) {
    processing.value = true;
    return new Promise((resolve, reject) => {
        axios
            .get(props.url as string, {
                params,
            })
            .then((res) => {
                const v = res.data;
                data.value = v.data;
                if (res.data.meta) {
                    page.current_page = v.meta.current_page;
                    page.last_page = v.meta.last_page;
                } else {
                    page.last_page = 0;
                }
                resolve(res);
            })
            .catch((e) => {
                console.log(e);
            })
            .finally(() => {
                processing.value = false;
            });
    });
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
    if (!dropdown.value?.contains(e.target)) {
        open.value = false;
    }
}

function fetchMore() {
    fetchData({
        search: search.value,
        page: page.current_page + 1,
    }).then((res: any) => {
        const v = res.data;
        data.value = [...data.value, ...v.data];

        if (v.meta) {
            page.current_page = v.meta.current_page;
            page.last_page = v.meta.last_page;
        } else {
            page.last_page = 0;
        }
    });
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

watch(open, (value: boolean) => {
    if (value) {
        if (data.value.length == 0 && props.url) {
            fetchData({
                search: search.value,
            });
        }
        document.addEventListener("keydown", closeOnEscape);
        document.addEventListener("click", closeOnClickOutside);
    } else {
        document.removeEventListener("keydown", closeOnEscape);
        document.removeEventListener("click", closeOnClickOutside);
    }
});

onMounted(() => {
    if (model.value && props.url) {
        fetchData();
    }
});
</script>

<template>
    <div :class="[labelInline ? 'flex items-center' : 'flex flex-col']" class="w-full flex-1 gap-2">
        <InputLabel :value="label" />

        <div
            class="relative w-full focus-visible:outline-gray-800 focus-visible:ring-transparent"
            :tabindex="tabindex"
            ref="dropdown">
            <div class="relative w-full">
                <div :class="[inputClass]" @click="openToggle">
                    <span v-if="selected === undefined || selected.length === 0" class="text-gray-400">
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
                <div class="absolute right-4 top-1/2 -translate-y-1/2 transform cursor-pointer">
                    <fa-icon @click="openToggle" :icon="faChevronDown" />
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
                    class="fixed z-40 mt-2 rounded-md bg-gray-50 py-2 shadow-lg dark:bg-gray-700">
                    <div class="max-h-80 overflow-auto">
                        <div class="mb-2 px-2" v-if="showSearch && data.length">
                            <TextInput @input="searching" v-model="search" ref="inputSearch" />
                        </div>
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
                                <div
                                    v-if="page.current_page !== page.last_page && page.last_page !== 0"
                                    class="cursor-pointer bg-gray-800 py-3.5 pl-4"
                                    @click="fetchMore">
                                    View more
                                </div>
                            </template>
                            <span class="py-3.5 pl-4" v-else>No option</span>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>

<style scoped></style>
