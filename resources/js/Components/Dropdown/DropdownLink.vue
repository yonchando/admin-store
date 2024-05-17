<script setup>
import {Link} from '@inertiajs/vue3';

defineOptions({
    inheritAttrs: false
})

defineProps({
    title: String,
    icon: String|Object,
});

const className = [
    'px-4',
    'py-3',
    'inline-block'
];
</script>

<template>
    <div class="">
        <Link :class="className" v-if="$attrs.href" v-bind="$attrs">
            <i class="min-w-8" v-if="typeof icon === 'string'" :class="icon"></i>
            <fa class="min-w-8" v-else :icon="icon" />
            <slot>{{ title }}</slot>
        </Link>

        <button :class="className" v-else v-bind="$attrs">
            <i class="min-w-8" v-if="typeof icon === 'string'" :class="icon"></i>
            <fa class="min-w-8" v-else :icon="icon"/>
            <slot>{{ title }}</slot>
        </button>
    </div>
</template>
