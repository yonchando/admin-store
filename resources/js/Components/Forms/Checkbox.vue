<script setup>
import { computed } from "vue";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { faSquare, faSquareCheck } from "@fortawesome/free-regular-svg-icons";

defineOptions({
    inheritAttrs: false,
});

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    label: String,
    value: {
        default: null,
    },
    modelValue: [Array, Boolean],
    severity: {
        type: String,
        default: "default",
        validator(value) {
            return ["primary", "success", "warning", "danger"].includes(value);
        },
    },
    position: {
        type: String,
        default: "right",
        validator(value) {
            return ["right", "left"].includes(value);
        },
    },
});

const proxyChecked = computed({
    get() {
        if (Array.isArray(props.modelValue)) {
            return props.modelValue.includes(props.value);
        }
        return props.modelValue;
    },

    set(val) {
        if (Array.isArray(props.modelValue)) {
            let newValue;
            if (val) {
                newValue = [...props.modelValue, props.value];
            } else {
                newValue = props.modelValue.filter(
                    (item) => item !== props.value,
                );
            }
            emit("update:modelValue", newValue);
        } else {
            emit("update:modelValue", val);
        }
    },
});

const severities = computed(() => {
    return {
        default: "text-dark-400",
        primary: "text-primary",
        success: "text-success",
        warning: "text-warning",
        danger: "text-danger",
    }[props.severity];
});

const classBox = computed(() => {
    return [severities.value];
});
</script>

<template>
    <div class="flex items-center gap-1">
        <div
            class="relative z-10 inline-block cursor-pointer rounded-sm text-center align-middle"
        >
            <input
                v-bind="$attrs"
                type="checkbox"
                :value="value"
                v-model="proxyChecked"
                class="absolute inset-0 z-20 h-full w-full cursor-pointer appearance-auto opacity-0"
            />
            <fa-icon
                size="xl"
                :class="classBox"
                v-if="proxyChecked"
                :icon="faSquareCheck"
            />
            <fa-icon
                size="xl"
                :class="classBox"
                v-if="!proxyChecked"
                :icon="faSquare"
            />
        </div>
        <label :for="$attrs.id" class="font-medium"> Remember </label>
    </div>
</template>
