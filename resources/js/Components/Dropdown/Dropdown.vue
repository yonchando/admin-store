<script setup>
import {computed, onMounted, onUnmounted, reactive, ref} from 'vue';
import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";


const props = defineProps({
    title: {
        required: false,
        type: String
    },
    toggleClass: String,
    show: {
        type: Boolean,
        default: false
    }
});

let isShow = ref(props.show);

</script>

<template>
    <li class="dropdown" :class="{'show': isShow}">
        <DropdownToggle :class="toggleClass" @onToggle="(toggle) => isShow = toggle">
            <slot name="toggle"></slot>
        </DropdownToggle>

        <div class="dropdown-menu dropdown-menu-right" :class="{'show': isShow}">
            <slot/>
        </div>
    </li>
</template>
