<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed, reactive, ref, watch } from "vue";
import TextInput from "@/Components/Forms/TextInput.vue";

const props = defineProps({
    modelValue: [String, Number],
    items: Array,
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

const search = ref(null);

const data = computed(() => {
    if (search.value !== null) {
        return props.items.filter((item) =>
            item[props.text].toLowerCase().includes(search.value.toLowerCase()),
        );
    }

    return props.items;
});

const defaultSelected =
    props.modelValue != null
        ? props.items.find((item) => item[props.id] == props.modelValue)
        : null;

const selected = reactive({
    id: defaultSelected ? defaultSelected[props.id] : null,
    text: defaultSelected ? selectText(defaultSelected) : null,
});

const collapse = reactive({
    open: false,
});

const $emit = defineEmits(["update:modelValue"]);

const collapseDropdown = ref(null);

const collapseSelect = ref(null);

function selectText(item) {
    if (typeof props.text === "function") {
        return props.text(item);
    } else {
        if (typeof item[props.text] === "undefined") {
            return "";
        }
        return lang[item[props.text].toLowerCase()] ?? item[props.text];
    }
}

function keydownEvent(event) {
    if (event.key === "Escape") {
        close();
    }
}

function clickEvent(event) {
    if (
        collapseSelect.value !== event.target &&
        collapseSelect.value !== event.target.parentNode &&
        !event.target !== collapseDropdown.value &&
        !event.target.closest("#select-input-search")
    ) {
        close();
    }
}

const close = () => {
    collapse.open = false;
    search.value = null;
    data.value = props.items ?? [];

    document.removeEventListener("keydown", keydownEvent);
    document.removeEventListener("click", clickEvent);
};

function open() {
    if (props.disabled) {
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
    if (props.disabled) {
        return;
    }
    selected.id = null;
    selected.text = null;

    $emit("update:modelValue", selected.id);
}

function select(item) {
    selected.id = item[props.id];
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
            ref="collapseSelect"
            @click="open()"
        >
            <span v-if="selected.id == null" class="text-muted">
                {{ placeholder ?? lang.please_selected }}
            </span>
            <span v-if="selected.id != null" class="tw-capitalize">
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
                :class="{
                    show: collapse.open && !disabled,
                }"
                ref="collapseDropdown"
                class="tw-absolute tw-left-0 tw-right-0 tw-top-full tw-z-50 tw-mt-1 tw-grid tw-w-full tw-grid-cols-1 tw-grid-rows-1"
            >
                <div
                    class="tw-relative tw-mb-8 tw-rounded-md tw-border tw-border-gray-200 tw-bg-white tw-shadow-lg"
                >
                    <div
                        v-if="!hideSearch"
                        class="tw-flex tw-justify-center tw-px-[0.875rem] tw-py-[.4375rem] tw-text-black"
                    >
                        <TextInput v-model="search" id="select-input-search" />
                    </div>

                    <div class="tw-max-h-56 tw-max-w-full tw-overflow-y-scroll">
                        <template v-if="data.length > 0">
                            <div
                                v-for="item in data"
                                :key="item[id]"
                                class="tw-cursor-pointer tw-px-[0.875rem] tw-py-[.4375rem] tw-capitalize tw-text-black hover:tw-bg-gray-100"
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
