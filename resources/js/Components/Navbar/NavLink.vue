<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    active: Boolean,
    label: String,
    icon: [String, Object],
});
const iconClass = ["top-0", "w-5", "max-w-5", "inline-block", "mr-3"];

const btnClass = [
    "relative",
    "inline-flex",
    "items-center",
    "px-5",
    "py-3",
    "font-medium",
    "transition-colors",
    "duration-150",
    "ease-in-out",
    props.active ? "bg-active" : "",
];
</script>

<template>
    <Link v-if="$attrs.href" :class="btnClass" v-bind="$attrs">
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

    <button v-else :class="btnClass" v-bind="$attrs">
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
    </button>
</template>
