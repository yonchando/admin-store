<script setup>
import {computed} from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: [Array, Boolean],
    value: {
        default: null,
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
                newValue = props.modelValue.filter(item => item !== props.value);
            }
            emit('update:modelValue', newValue);
        } else {
            emit('update:modelValue', val);
        }
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="form-check-input-styled"
    />
</template>
