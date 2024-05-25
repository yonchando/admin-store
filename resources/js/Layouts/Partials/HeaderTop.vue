<script setup>
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
import DropdownLink from "@/Components/Dropdowns/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Breadcrumb.vue";
import { computed } from "vue";
import useBreadcrumbs from "@/breadcrumbs.js";

defineEmits(["open-sidebar"]);

defineProps({
    title: String,
});

const breadcrumbs = computed(() => {
    let breadcrumb = useBreadcrumbs();
    return (
        breadcrumb[route().current()] ?? [
            { label: "Dashboard", icon: "icon-home2" },
        ]
    );
});
</script>

<template>
    <div class="static left-0 right-0 top-0 z-20 min-h-14 sm:fixed sm:left-64">
        <div
            class="flex items-center justify-between bg-dark-200 p-2 text-white"
        >
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

            <h3 class="text-lg font-semibold">
                <slot>{{ title }}</slot>
            </h3>

            <div
                class="col-span-2 hidden h-full items-center sm:col-span-1 sm:flex sm:justify-self-end"
            >
                <Dropdown class="mt-4">
                    <template #button>
                        <span class="flex items-center gap-4">
                            <img
                                class="h-8 w-8 rounded-full"
                                src="/assets/images/placeholders/placeholder.jpg"
                                alt="Profile"
                            />
                            {{ $page.props.auth.user.name }}
                        </span>
                    </template>
                    <dropdown-link
                        class="text-dark-400"
                        :title="$lang.profile"
                        icon="fa fa-user"
                        :href="route('profile.edit')"
                    />
                    <dropdown-link
                        class="text-dark-400"
                        :title="$lang.logout"
                        method="post"
                        icon="fa fa-arrow-right-from-bracket"
                        :href="route('logout')"
                    />
                </Dropdown>
            </div>
        </div>
        <div
            class="bg-light-400 relative flex flex-wrap border-y border-y-transparent px-5"
        >
            <Breadcrumb :values="breadcrumbs" />
        </div>
    </div>
</template>
