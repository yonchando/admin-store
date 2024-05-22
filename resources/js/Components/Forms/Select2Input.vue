<script setup>
import {onMounted, onUnmounted} from "vue";

const props = defineProps({
    modelValue: {
        type: String,
    },
    items: {
        type: Array,
        default: []
    },
    placeholder: {
        type: String,
        default: 'Please Select...'
    },
    disableSearch: {
        type: Boolean,
        default: false
    },
    allowClear: {
        type: Boolean,
        default: true,
    },
    text: {
        type: String,
        default: 'name',
    },
    id: {
        type: String,
        default: 'id',
    }

});

const $emit = defineEmits("update:modelValue");

const updateValue = (event) => {
    $emit('update:modelValue', $(this).val());
}
</script>
<template>
    <select class="form-control" @change="updateValue($event)">
        <option value=""></option>
        <template v-if="items.length > 0">
            <option v-for="item in items"
                    :value="item.id"
                    v-text="item.name"></option>
        </template>
    </select>
</template>

<style scoped>
</style>
