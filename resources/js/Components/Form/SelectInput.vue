<script setup>
import {usePage} from "@inertiajs/vue3";
import TextInput from "./TextInput.vue";
import {ref, reactive, computed} from "vue";
import {watch} from "vue";

const {modelValue, items, id, text, disabled} = defineProps({
    modelValue: String,
    items: Object,
    id: {
        type: String,
        default: "id",
    },
    text: {
        type: [Object, String],
        default: "text",
    },
    placeholder: String,
    hideSearch: {
        type: Boolean,
        default: false,
    },
    disabled: Boolean,
    disabledClear: Boolean,
});

const lang = usePage().props.lang;

let data = ref(items ?? []);

const search = ref(null);

watch(search, (value) => {
    if (value) {
        data.value = items.filter((item) => {
            return item[text].toLowerCase().includes(value.toLowerCase());
        });
    }
});

const selectText = (item) => {
    if (typeof text === "function") {
        return text(item);
    } else {
        if (typeof item[text] === "undefined") {
            return "";
        }
        return lang[item[text].toLowerCase()] ?? item[text];
    }
};

const defaultSelected =
    modelValue != null ? items.find((item) => item[id] == modelValue) : null;

const selected = reactive({
    id: defaultSelected ? defaultSelected[id] : null,
    text: defaultSelected ? selectText(defaultSelected) : null,
});

const collapse = reactive({
    open: false,
});

const $emit = defineEmits("update:modelValue");

function keydownEvent(event) {
    if (event.key === "Escape") {
        close();
    }
}

function clickEvent(event) {
    if (!event.target.closest("#collapse") &&
        !event.target.closest("#select-input-search")) {
        close();
    }
}

const close = () => {
    collapse.open = false;
    search.value = null;
    data.value = items ?? [];

    document.removeEventListener("keydown", keydownEvent);
    document.removeEventListener("click", clickEvent);
};

function open() {
    if (disabled) {
        return;
    }

    collapse.open = !collapse.open;

    if (!collapse.open) {
        close();
        return;
    }

    document.addEventListener("keydown", keydownEvent);

    document.addEventListener("click", clickEvent);
}

function clear() {
    if (disabled) {
        return;
    }
    selected.id = null;
    selected.text = null;

    $emit("update:modelValue", selected.id);
}

function select(item) {
    selected.id = item[id];
    selected.text = selectText(item);
    close();

    $emit("update:modelValue", selected.id);
}
</script>
<template>
    <div class="tw-relative">
        <div
            class="tw-flex tw-w-full tw-items-center tw-rounded tw-border tw-px-[0.875rem] tw-py-[.4375rem]"
            :class="{
                'tw-bg-gray-100/75': disabled,
            }"
            id="collapse"
            @click="open()"
        >
            <span v-if="selected.id == null" class="text-muted">
                {{ placeholder ?? lang.please_selected }}
            </span>
            <span v-if="selected.id != null" class="">
                {{ selected.text }}
            </span>
        </div>
        <i
            v-if="!disabledClear"
            @click="clear()"
            class="tw-absolute tw-right-2 tw-top-1/2 -tw-translate-y-1/2"
            :class="{
                'icon-chevron-down':
                    (!collapse.open && selected.id === null) || disabled,
                'icon-chevron-up': collapse.open && selected.id === null,
                'icon-x tw-cursor-pointer': selected.id && !disabled,
            }"
        ></i>
        <Transition
            name="fade"
            enter-active-class="animate__animated animate__fadeIn animate__super_faster fade-enter-active"
            leave-active-class="animate__animated animate__fadeOut animate__super_faster fade-leave-active"
        >
            <div
                v-show="collapse.open && !disabled"
                class="tw-absolute tw-left-0 tw-right-0 tw-top-full tw-z-50 tw-grid tw-w-full tw-grid-cols-1 tw-grid-rows-1"
            >
                <div
                    class="tw-relative tw-rounded-md tw-border tw-border-gray-200 tw-bg-white tw-shadow-lg"
                >
                    <div
                        v-if="!hideSearch"
                        class="tw-flex tw-justify-center tw-px-[0.875rem] tw-py-[.4375rem] tw-text-black"
                    >
                        <TextInput focus v-model="search" id="select-input-search"/>
                    </div>

                    <div class="tw-max-h-56 tw-max-w-full tw-overflow-y-scroll">
                        <template v-if="data.length > 0">
                            <div
                                v-for="item in data"
                                :key="item[id]"
                                class="tw-cursor-pointer tw-px-[0.875rem] tw-py-[.4375rem] tw-text-black hover:tw-bg-gray-100 tw-capitalize"
                                :class="{
                                    'tw-bg-gray-100': selected.id === item[id],
                                }"
                                @click="select(item)"
                            >
                                {{ selectText(item) }}
                            </div>
                        </template>

                        <template v-else>
                            <div
                                class="tw-px-[0.875rem] tw-py-[.4375rem] tw-text-black hover:tw-bg-gray-100"
                            >
                                {{ lang.empty }}
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.animate__super_faster {
    animation-duration: 200ms;
}
</style>
