<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    links: Array,
    perEach: {
        type: Number,
        default: 5,
    },
});

const pages = computed(() => {
    const links = [];
    links.push(props.links.filter((_, i) => i < props.perEach));
    links.push([]);
    links.push(
        props.links.filter((_, i) => i > props.links.length - props.perEach),
    );

    return props.links;
});
</script>
<template>
    <ul class="pagination pagination-rounded align-self-center tw-mt-4">
        <template v-if="links.length > 0">
            <template v-for="(link, i) in pages">
                <li
                    class="page-item"
                    :class="{
                        active: link.active,
                        disabled: link.url == null,
                    }"
                >
                    <Link
                        :href="link.url"
                        class="page-link"
                        v-html="link.label"
                    />
                </li>
            </template>
        </template>
    </ul>
</template>
