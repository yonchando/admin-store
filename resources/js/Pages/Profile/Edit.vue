<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";
import Card from "@/Components/Card/Card.vue";

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Profile</h2>
        </template>

        <template #additional_info>
            <div class="space-y-6">
                <Card class="p-4">
                    <UpdateProfileInformationForm :status="status" class="max-w-xl" />
                </Card>

                <Card class="p-4">
                    <UpdatePasswordForm class="max-w-xl" />
                </Card>
            </div>
        </template>
    </AppLayout>
</template>
