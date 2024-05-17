<script setup>

import {Link} from "@inertiajs/vue3";

defineProps({
    title: String,
    icon: String | Object,
});

const className = [
    'px-3',
    'py-2.5',
    'rounded-md',
    'inline-block'
];

</script>

<template>
        <Link :class="className" v-if="$attrs.href" v-bind="$attrs">
            <i v-if="typeof icon === 'string'" :class="icon"></i>
            <fa v-else :icon="icon"/>
            <slot>{{ title }}</slot>
        </Link>

        <button :class="className" v-else v-bind="$attrs">
            <i class="mr-2" v-if="typeof icon === 'string'" :class="icon"></i>
            <fa class="mr-2" v-else :icon="icon"/>
            <slot>{{ title }}</slot>
        </button>
</template>

<style scoped>

</style>