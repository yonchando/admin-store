<script setup>
import {usePage} from "@inertiajs/vue3";
import TextInput from "./TextInput.vue";
import {ref, reactive} from "vue";
import {watch} from "vue";

const {modelValue, items, id, text} = defineProps({
    modelValue: String,
    items: Array,
    id: {
        type: String,
        default: 'id',
    },
    text: String,
    placeholder: String,
});

const lang = usePage().props.lang;

let data = ref(items);

const search = ref(null);

watch(search, (value) => {
    if (value) {
        data.value = items.filter((item) => {
            return item[text].toLowerCase().includes(value.toLowerCase());
        });
    }
});

const defaultSelected = items.find((item) => item[id] === modelValue);

const selected = reactive({
    id: defaultSelected ? defaultSelected[id] : null,
    text: defaultSelected ? defaultSelected[text] : null,
});

const collapse = reactive({
    open: false,
});

let keydown = (event) => {
    if (event.key === "Escape") {
        close();
    }
};

let click = (event) => {
    if (
        !event.target.closest("#collapse") &&
        !event.target.closest("#select-input-search")
    ) {
        close();
    }
};

const close = () => {
    collapse.open = false;
    search.value = null;
    data.value = items;

    document.removeEventListener("keydown", keydown);
    document.removeEventListener("click", click);
};

const open = () => {
    collapse.open = !collapse.open;

    if (!collapse.open) {
        close();
        return;
    }

    document.addEventListener("keydown", keydown);

    document.addEventListener("click", click);
};

const $emit = defineEmits("update:modelValue");

defineExpose({focus: () => input.value.focus()});

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
            class="tw-flex tw-w-full tw-cursor-pointer tw-items-center tw-rounded tw-border tw-px-[0.875rem] tw-py-[.4375rem]"
            id="collapse"
            @click="open()"
        >
            <span v-if="selected.id == null" class="text-muted tw-opacity-50">
                {{ placeholder ?? lang.please_selected }}
            </span>
            <span v-if="selected.id != null" class="">
                {{ selected.text }}
            </span>
        </div>
        <i
            class=" tw-absolute tw-right-2 tw-top-1/2 -tw-translate-y-1/2"
            :class="{
                'icon-chevron-down': !collapse.open,
                'icon-chevron-up': collapse.open,
            }"
        ></i>
        <Transition
            name="fade"
            enter-active-class="animate__animated animate__fadeIn animate__slow fade-enter-active"
            leave-active-class="animate__animated animate__fadeOut animate__slow fade-leave-active"
        >
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
                        <TextInput v-model="search" id="select-input-search"/>
                    </div>
                    <template v-if="data.length > 0">
                        <div
                            class="tw-cursor-pointer tw-px-[0.875rem] tw-py-[.4375rem] tw-text-black hover:tw-bg-gray-100"
                            :class="{
                                'tw-bg-gray-100': selected.id == item[id],
                            }"
                            v-for="item in data"
                            :key="item[id]"
                            :value="item[id]"
                            @click="select(item)"
                        >
                            {{ item[text] }}
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
        </Transition>
    </div>
</template>

<style scoped>
.fade-enter-active {
    animation-name: fade-in;
    animation-duration: 0.2s;
}

.fade-leave-active {
    animation-name: fade-out;
    animation-duration: 0.2s;
}

@keyframes fade-in {
    0% {
        height: 0;
        opacity: 0;
    }
    100% {
        height: 100%;
        opacity: 1;
    }
}

@keyframes fade-out {
    0% {
        height: 100%;
        opacity: 1;
    }
    100% {
        height: 0;
        opacity: 0;
    }
}
</style>
