<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    active: {
        type: Boolean,
    },
    label: String,
    icon: [String, Object],
});
const iconClass = ["top-0", "mr-5"];
</script>

<template>
    <Link
        class="relative flex items-center px-5 py-3 font-medium transition-colors duration-150 ease-in-out"
    >
        <slot>
            <template v-if="icon">
                <i
                    v-if="typeof icon === 'string'"
                    :class="[icon, ...iconClass]"
                ></i>
                <fa-icon v-else :icon="icon" :class="iconClass" />
            </template>
            <span>{{ label }}</span>
        </slot>
    </Link>
</template>
