<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    modelValue: {
        type: Object,
        default: null,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
});

const lang = usePage().props.lang;

let src = ref();

const $emit = defineEmits(["update:modelValue"]);

const modelChange = ($event) => {
    if (props.multiple) {
        $emit("update:modelValue", $event.target.files);
    } else {
        const reader = new FileReader();

        reader.onload = function (result) {
            src.value = result.target.result;
        };

        reader.readAsDataURL($event.target.files[0]);

        $emit("update:modelValue", $event.target.files[0]);
    }
};
</script>
<template>
    <div class="relative w-full">
        <span
            v-if="!src"
            class="flex items-center justify-center rounded-md text-lg font-medium border-2 border-gray-300 p-10 w-full border-dashed text-gray-400"
        >
            Drop and drag image here
        </span>
        <img
            :src="src"
            v-else
            class="w-full rounded-md shadow"
            alt="product feature"
        />
        <input
            type="file"
            @input="modelChange($event)"
            accept="image/*"
            class="absolute inset-0 flex h-full w-full cursor-pointer items-center justify-center rounded-md bg-red-50 opacity-0"
        />
    </div>
</template>
