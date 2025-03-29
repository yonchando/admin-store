<script setup lang="ts">
import { Head, usePage } from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { Action } from "@/types/button";
import { h, onMounted, watch } from "vue";
import StartToastifyInstance from "toastify-js";
import Alert from "@/Components/Alert/Alert.vue";
import { Flash, FlashKey } from "@/types/flash";
import Card from "@/Components/Card/Card.vue";

defineProps<{
    title?: string;
    actions?: Action[];
}>();

const page = usePage();

const severities: Flash = {
    primary: "bg-none shadow bg-primary text-white",
    success: "bg-none shadow bg-success text-white",
    info: "bg-none shadow bg-info text-white",
    warning: "bg-none shadow bg-warning text-white",
    error: "bg-none shadow bg-error text-white",
};

watch(
    () => page.props.flash,
    (newValue: any) => {
        alertMessage(newValue);
    },
);

function alertMessage(messages: Flash) {
    for (const flash of Object.keys(messages)) {
        const key = flash as FlashKey;
        if (messages[key]) {
            StartToastifyInstance({
                text: messages[key],
                duration: 3000,
                newWindow: true,
                close: false,
                gravity: "top",
                position: "center",
                className: severities[key],
            }).showToast();
            messages[key] = "";
        }
    }
}

onMounted(() => {
    alertMessage(page.props.flash);
});
</script>

<template>
    <Head :title="title" />

    <div class="bg-slate-50 dark:bg-gray-900">
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
                <main class="px-2">
                    <Card class="min-h-[calc(100dvh-4rem)]">
                        <slot />
                    </Card>
                    <slot name="additional_info" />
                </main>
            </div>
        </div>
    </div>

    <Alert />
</template>
