<script setup>
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { computed } from "vue";
import {
    faArrowRightFromBracket,
    faUser,
} from "@fortawesome/free-solid-svg-icons";

defineEmits(["open-sidebar"]);

defineProps({
    title: String,
});

const options = computed(() => {
    return [
        {
            label: "Profile",
            icon: faUser,
            href: route("profile.edit"),
        },
        {
            label: "Logout",
            icon: faArrowRightFromBracket,
            href: route("logout"),
            method: "POST"
        },
    ];
});
</script>

<template>
    <!-- Header -->
    <div class="flex items-center justify-between bg-dark-200 p-2 text-white">
        <div class="inline-block sm:hidden">
            <Link :href="route('dashboard')" class="inline-block">
                <ApplicationLogo width="120" height="50" />
            </Link>
        </div>

        <button
            id="btn-open-sidebar"
            class="text-right sm:hidden"
            @click="$emit('open-sidebar')"
        >
            <i class="fa fa-list text-2xl"></i>
        </button>

        <div class="hidden flex-grow items-center justify-between sm:flex">
            <h3 class="text-lg font-semibold">
                <slot>{{ title }}</slot>
            </h3>

            <div
                class="col-span-2 hidden h-full items-center sm:col-span-1 sm:flex sm:justify-self-end"
            >
                <Dropdown :options="options">
                    <template #value>
                        <img class="w-8 h-8 rounded-full" src="/assets/images/placeholders/placeholder.jpg" alt="">
                        <span>{{$page.props.auth.user.name}}</span>
                    </template>
                </Dropdown>
            </div>
        </div>
    </div>
</template>

<style></style>