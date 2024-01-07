<script setup>
import {computed, onMounted, onUnmounted, reactive, ref} from "vue";
import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";

const props = defineProps({
    title: {
        required: false,
        type: String,
    },
    toggleClass: String,
    show: {
        type: Boolean,
        default: false,
    },
});

</script>

<template>
    <ul class="navbar-nav ml-auto">
        <li class="dropdown" :class="{ show: show }">
            <slot name="toggle">
                <DropdownToggle :title="title"/>
            </slot>

            <div
                class="dropdown-menu dropdown-menu-right"
                :class="{ show: show }"
            >
                <slot/>
            </div>
        </li>
    </ul>
</template>
