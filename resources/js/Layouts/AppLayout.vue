<script setup lang="ts">
import { Head, usePage } from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { Action } from "@/types/button";
import { onMounted, watch } from "vue";
import StartToastifyInstance from "toastify-js";
import Alert from "@/Components/Alert/Alert.vue";

defineProps<{
    title?: string;
    actions?: Action[];
}>();

const page = usePage();

const severities: any = {
    success: "bg-none shadow bg-teal-600 text-gray-300",
    info: "bg-none shadow bg-sky-600 text-gray-300",
    warning: "bg-none shadow bg-amber-600 text-gray-300",
    error: "bg-none shadow bg-rose-600 text-white",
};

watch(
    () => page.props.flash,
    (newValue: any) => {
        alertMessage(newValue);
    },
);

function alertMessage(messages: any) {
    for (const flash in messages) {
        if (messages[flash]) {
            StartToastifyInstance({
                text: messages[flash],
                duration: 3000,
                newWindow: true,
                close: false,
                gravity: "top",
                position: "center",
                className: severities[flash],
            }).showToast();
        }
    }
}

onMounted(() => {
    alertMessage(page.props.flash);
});
</script>

<template>
    <Head :title="title">
        <link rel="icon" type="image/x-icon" href="@assets/images/logos/logo.png" />
    </Head>

    <div class="bg-white dark:bg-gray-900">
        <div class="flex">
            <Sidebar />

            <div class="flex max-h-screen min-h-screen w-full flex-col overflow-auto">
                <header class="" v-if="$slots.header">
                    <div class="flex w-full items-center px-4 py-2">
                        <h3 class="text-lg font-semibold">
                            <slot name="header" />
                        </h3>

                        <div class="ml-auto flex items-center justify-center gap-2">
                            <template v-for="action in actions">
                                <component :is="action.component" :icon="action.icon" v-bind="action.props">
                                    {{ action.label }}
                                </component>
                            </template>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-2">
                    <div class="rounded-md bg-white p-1 text-gray-900 dark:bg-gray-800 dark:text-gray-200">
                        <slot />
                    </div>
                </main>
            </div>
        </div>
    </div>

    <Alert />
</template>
