<script setup lang="ts">
import { nextTick, reactive, ref, watch } from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { faChevronDown, faTimes } from "@fortawesome/free-solid-svg-icons";
import _ from "lodash";
import TextInput from "@/Components/Forms/TextInput.vue";
import axios from "axios";
import { Paginate } from "@/types/paginate";

const props = withDefaults(
    defineProps<{
        label?: string;
        options: Array<any>;
        optionValue?: any;
        optionLabel?: any;
        placeholder?: string;
        url?: string;
        showSearch?: boolean;
        paginate?: Paginate<any>;
    }>(),
    {
        optionValue: "id",
        optionLabel: "name",
        showSearch: true,
    },
);

const model = defineModel();

const inputClass = [
    "flex justify-between items-center",
    "w-full",
    "px-4 py-2.5",
    "cursor-pointer",
    "rounded-md",
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

const selected = ref(null);

const search = ref<string>("");

const inputSearch = ref<HTMLInputElement | null>(null);

const data = ref<Array<any>>([]);

const page = reactive({
    current_page: props.paginate?.current_page ?? 2,
    last_page: props.paginate?.last_page ?? 0,
});

const processing = ref(false);
const searching = _.debounce(
    () => {
        if (!props.url) {
            data.value = props.options.filter((item: any) => {
                return _.get(item, props.optionLabel).toLowerCase().startsWith(search.value.toLowerCase());
            });
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

function fetchData(params = {}) {
    processing.value = true;
    return new Promise((resolve, reject) => {
        axios
            .get(props.url as string, {
                params,
            })
            .then((res) => {
                resolve(res);
            })
            .catch((e) => {
                reject(e.response);
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
    if (typeof props.optionValue === "string") {
        model.value = _.get(option, props.optionValue);
    } else {
        model.value = props.optionValue(option);
    }

    selected.value = option;
    open.value = false;
}

watch(open, (value: boolean) => {
    if (value) {
        if (data.value.length == 0) {
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
        document.addEventListener("keydown", closeOnEscape);
        document.addEventListener("click", closeOnClickOutside);
    } else {
        document.removeEventListener("keydown", closeOnEscape);
        document.removeEventListener("click", closeOnClickOutside);
    }
});
</script>

<template>
    <InputLabel :value="label" />
    <div class="relative mt-2" ref="dropdown">
        <div class="relative">
            <div :class="[inputClass]" @click="openToggle">
                <span v-if="!selected" class="text-gray-400">
                    {{ placeholder ?? "Select option" }}
                </span>
                <span v-else class="text-gray-400">
                    <template v-if="(typeof optionLabel as any) == 'string'">
                        {{ _.get(selected, optionLabel) }}
                    </template>
                    <template v-else>
                        {{ optionLabel(selected) }}
                    </template>
                </span>
            </div>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 transform cursor-pointer">
                <fa-icon
                    @click="
                        () => {
                            model = null;
                            selected = null;
                        }
                    "
                    v-if="selected"
                    :icon="faTimes" />
                <fa-icon @click="openToggle" v-else :icon="faChevronDown" />
            </div>
        </div>

        <Transition
            enter-active-class="transition-[max-height,opacity] ease-in-out duration-100 overflow-hidden"
            enter-from-class="max-h-0 opacity-0"
            enter-to-class="max-h-96 opacity-100"
            leave-active-class="transition-all ease-in-out duration-100 overflow-hidden"
            leave-from-class="max-h-96 opacity-100"
            leave-to-class="max-h-0 opacity-0">
            <div v-show="open" class="absolute inset-x-0 mt-2 rounded-md py-2 shadow-lg dark:bg-gray-700">
                <div class="max-h-80 overflow-auto">
                    <div class="mb-3 px-2" v-if="showSearch && data.length">
                        <TextInput @input="searching" v-model="search" ref="inputSearch" />
                    </div>
                    <div class="flex flex-shrink-0 flex-grow-0 flex-col">
                        <template v-if="data.length > 0">
                            <template v-for="option in data">
                                <button
                                    @click="setModel(option)"
                                    class="cursor-pointer py-3.5 pl-4 text-left hover:bg-gray-900">
                                    <template v-if="typeof optionLabel == 'string'">
                                        {{ _.get(option, optionLabel) }}
                                    </template>
                                    <template v-else>
                                        {{ optionLabel(option) }}
                                    </template>
                                </button>
                            </template>
                            <button
                                v-if="page.current_page !== page.last_page && page.last_page !== 0"
                                class="cursor-pointer bg-gray-800 py-3.5 pl-4"
                                @click="fetchMore">
                                View more
                            </button>
                        </template>
                        <span class="py-3.5 pl-4" v-else>No option</span>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped></style>
