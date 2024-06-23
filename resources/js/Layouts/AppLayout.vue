<script setup>
import Header from "@/Layouts/Partials/Header.vue";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumbs/Breadcrumb.vue";
import Button from "@/Components/Buttons/Button.vue";

defineProps({
    title: String,
    showSidebar: {
        type: Boolean,
        default: true,
    },
    showHeaderTop: {
        type: Boolean,
        default: true,
    },
    actions: [Array, Object],
    searchProps: Object,
    hasSearch: {
        type: Boolean,
        default: false,
    }
});

const search = defineModel("search");

const open = ref(false);
</script>

<template>
    <Head>
        <slot name="head">
            <title>{{ title }}</title>
        </slot>
    </Head>

    <div class="flex max-h-screen">
        <Sidebar
            v-if="showSidebar"
            :show="open"
            @close-sidebar="open = false"
        />

        <div class="relative flex flex-grow flex-col gap-0 min-h-screen">
            <div>
                <div class="flex max-h-48 flex-col overflow-hidden">
                    <Header class="" @open-sidebar="open = true">
                        {{ title }}
                    </Header>

                    <Breadcrumb>
                        <slot name="breadcrumb" />
                    </Breadcrumb>

                    <div
                        class="w-full border-t border-b border-gray-200 px-2 py-1.5"
                    >
                        <div class="flex justify-start gap-2">
                            <slot name="filters" v-if="$slots.filters || hasSearch">
                                <TextInput
                                    placeholder="Search..."
                                    v-model="search"
                                    v-bind="searchProps"
                                />
                            </slot>
                            <slot name="actions">
                                <div class="ml-auto flex justify-end gap-2">
                                    <template v-for="action in actions">
                                        <Button v-bind="action.props">
                                            <Icon :icon="action.icon" />
                                            {{ action.label }}
                                        </Button>
                                    </template>
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
            <!-- body -->
            <div class="w-full grid-cols-1 overflow-auto border border-dark flex-auto">
                <div class="px-2 bg-white py-1.5">
                    <slot />
                </div>
            </div>
            <!-- footer -->
            <div class="px-4 py-1.5 text-center bg-white">
                @Copyright - YON Chando 
            </div>
        </div>
    </div>
</template>
