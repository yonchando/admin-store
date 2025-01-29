<script setup lang="ts">
import { computed, onMounted, ref } from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";

defineOptions({
    inheritAttrs: false,
});

const props = withDefaults(
    defineProps<{
        label?: string;
        direction?: "horizontal" | "vertical";
        root?: any;
        required?: boolean;
        type?: string;
    }>(),
    {
        direction: "vertical",
        required: false,
        type: "text",
    },
);
const model = defineModel();

defineEmits<{
    (e: "change", event: any): void;
}>();

const input = ref<HTMLInputElement | null>(null);

const directionClass = computed(() => {
    return {
        vertical: "flex gap-2 flex-col",
        horizontal: "flex gap-4 flex-row items-center",
    }[props.direction];
});

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus();
    }

    if (input.value?.hasAttribute("datepicker")) {
        input.value?.addEventListener("input", function (e: any) {
            console.log(e.target.value);
        });
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <div :class="[directionClass]" v-bind="root">
        <slot name="label" v-if="$slots.label || label">
            <InputLabel :required="required" :value="label" :for="input?.getAttribute('id')" />
        </slot>
        <input class="form-input mt-auto" v-model="model" v-bind="$attrs" ref="input" :type="type" />
    </div>
</template>
