<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    data: Array,
    perEach: {
        type: Number,
        default: 5,
    },
});

const pages = computed(() => {
    return props.data.links;
});
</script>
<template>
    <div class="tw-mt-4 tw-flex tw-items-center tw-justify-between">
        <ul class="pagination pagination-rounded">
            <template v-if="pages.length > 3">
                <template v-for="link in pages">
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

        <span>
            <b>{{ $lang.page }}:</b>
            <span class="tw-mx-1">
                {{ data.current_page }} of {{ data.last_page }},
            </span>
            <b>{{ $lang.total }} </b> {{ data.total }}
        </span>
    </div>
</template>
