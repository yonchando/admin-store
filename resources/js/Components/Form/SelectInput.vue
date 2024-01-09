<script setup>
import { usePage } from "@inertiajs/vue3";
import TextInput from "./TextInput.vue";
import { ref, reactive } from "vue";

const { items, id, text } = defineProps([
    "modelValue",
    "items",
    "id",
    "text",
    "placeholder",
]);

const lang = usePage().props.lang;

let data = ref(items);

const selected = reactive({
    id: null,
    text: null,
});

const collapse = reactive({
    open: false,
});

const close = () => {
    collapse.open = false;
};

const open = () => {
    collapse.open = !collapse.open;

    if (!collapse.open) {
        close();
    }

    document.addEventListener("keydown", (event) => {
        if (event.key == "Escape") {
            close();
        }
    });

    document.addEventListener("click", (event) => {
        if (!event.target.closest("#collapse")) {
            close();
        }
    });
};

const $emit = defineEmits("update:modelValue");

defineExpose({ focus: () => input.value.focus() });

const select = (item) => {
    selected.id = item[id];
    selected.text = item[text];
    close();

    $emit("update:modelValue", selected.id);
};
</script>
<template>
    <div class="tw-relative">
        <div
            class="tw-flex tw-w-full tw-cursor-pointer tw-items-center tw-rounded tw-border tw-px-[0.875rem] tw-py-[.4375rem] tw-font-medium"
            id="collapse"
            @click="open()"
        >
            <span v-if="selected.id == null" class="">
                {{ placeholder ?? lang.please_selected }}
            </span>
            <span v-if="selected.id != null" class="">
                {{ selected.text }}
            </span>
        </div>
        <i
            class="icon-chevron-down tw-absolute tw-right-2 tw-top-1/2 -tw-translate-y-1/2"
        ></i>
        <div
            v-show="collapse.open"
            class="tw-absolute tw-left-0 tw-right-0 tw-top-full tw-z-50 tw-grid tw-w-full tw-grid-cols-1 tw-grid-rows-1"
        >
            <div
                class="tw-relative tw-max-h-56 tw-max-w-full tw-overflow-y-scroll tw-rounded-md tw-border tw-border-gray-200 tw-bg-white tw-shadow-lg"
            >
                <div
                    class="tw-flex tw-justify-center tw-px-[0.875rem] tw-py-[.4375rem] tw-text-black hover:tw-bg-gray-100"
                >
                    <TextInput class="" />
                </div>
                <template v-if="data.length > 0">
                    <div
                        class="tw-cursor-pointer tw-px-[0.875rem] tw-py-[.4375rem] tw-text-black hover:tw-bg-gray-100"
                        v-for="item in data"
                        :key="item[id]"
                        :value="item[id]"
                        @click="select(item)"
                    >
                        {{ item[text] }}
                    </div>
                </template>

                <template v-else>
                    {{ lang.empty }}
                </template>
            </div>
        </div>
    </div>
</template>
