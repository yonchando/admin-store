<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head} from '@inertiajs/vue3';
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";

</script>

<template>
    <Head title="Profile"/>

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Profile</h2>
        </template>
        
        <template #breadcrumb>
            <BreadcrumbItem icon="icon-user" title="Profile" />
        </template>
        
        <div class="">
            <div class="tw-space-y-6">
                <div class="tw-p-4 sm:tw-p-8 bg-white dark:tw-bg-gray-800 tw-shadow sm:tw-rounded-lg">
                    <UpdateProfileInformationForm class="tw-max-w-xl"/>
                </div>

                <div class="tw-p-4 sm:tw-p-8 bg-white dark:tw-bg-gray-800 tw-shadow sm:tw-rounded-lg">
                    <UpdatePasswordForm class="tw-max-w-xl"/>
                </div>
                
                <div class="tw-p-4 sm:tw-p-8 bg-white dark:tw-bg-gray-800 tw-shadow sm:tw-rounded-lg"
                     v-if="!$page.props.auth.user.is_admin">
                    <DeleteUserForm class="tw-max-w-xl"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
