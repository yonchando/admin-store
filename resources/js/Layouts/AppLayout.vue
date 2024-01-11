<script setup>
import HeaderTop from "@/Layouts/Partials/HeaderTop.vue";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import Breadcrumb from "@/Components/Breadcrumb/Breadcrumb.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import {router, usePage} from "@inertiajs/vue3";
import Loading from "./Partials/Loading.vue";
import {ref} from "vue";

defineProps({
    showSidebar: {
        type: Boolean,
        default: true,
    },
    showHeaderTop: {
        type: Boolean,
        default: true,
    },
});

const loading = ref(false);

router.on("start", () => {
    loading.value = true;
});

router.on("finish", () => {
    loading.value = false;
});

const lang = usePage().props.lang;
</script>

<template>
    <div>
        <div class="navbar-top">
            <HeaderTop v-if="showHeaderTop"/>

            <div class="page-content">
                <Sidebar v-if="showSidebar"/>

                <div class="content-wrapper">
                    <div class="page-header page-header-light">
                        <div
                            class="breadcrumb-line breadcrumb-line-light header-elements-md-inline"
                        >
                            <div class="d-flex">
                                <Breadcrumb>
                                    <BreadcrumbItem
                                        :title="lang.dashboard"
                                        icon="icon-home2"
                                        :href="route('dashboard')"
                                    />
                                    <slot name="breadcrumb"/>
                                </Breadcrumb>
                            </div>

                            <div class="header-elements d-none">
                                <Breadcrumb class="justify-content-center">
                                    <slot name="action"/>
                                </Breadcrumb>
                            </div>
                        </div>
                    </div>

                    <div class="content tw-mb-24 tw-px-2">
                        <slot/>
                    </div>

                    <div
                        class="tw-fixed tw-bottom-0 tw-right-0"
                        :style="{
                            left: showSidebar ? '16.875rem' : '0',
                        }"
                    >
                        <div class="navbar navbar-expand-lg navbar-light">
                            <div class="text-center d-lg-none w-100">
                                <button
                                    type="button"
                                    class="navbar-toggler dropdown-toggle"
                                    data-toggle="collapse"
                                    data-target="#navbar-footer"
                                >
                                    <i class="icon-unfold mr-2"></i>
                                    Footer
                                </button>
                            </div>

                            <div
                                class="navbar-collapse collapse"
                                id="navbar-footer"
                            >
                                <span class="navbar-text">
                                    &copy; 2023 - .
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Loading v-if="loading"/>
</template>
