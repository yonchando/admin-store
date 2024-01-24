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

const date = new Date();
</script>

<template>
    <HeaderTop v-if="showHeaderTop"/>

    <div class="page-content tw-h-full">
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

            <div class="navbar navbar-expand-lg navbar-light">
                <div id="navbar-footer" class="navbar-collapse">
                    <span class="navbar-text">
                        Copyright &copy; 2023 - {{ date.getFullYear() }}
                    </span>
                </div>
            </div>
        </div>
    </div>


    <Loading v-if="loading"/>
</template>
