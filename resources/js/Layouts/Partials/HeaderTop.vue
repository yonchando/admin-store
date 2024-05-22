<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";

defineEmits(["open-sidebar"]);
</script>

<template>
    <div
        class="fixed left-0 right-0 top-0 z-20 flex min-h-14 items-center justify-between bg-dark-200 p-2 text-white sm:left-64"
    >
        <div>
            <div class="inline-block sm:hidden">
                <Link :href="route('dashboard')" class="inline-block">
                    <ApplicationLogo width="120" height="50" />
                </Link>
            </div>
        </div>

        <button
            id="btn-open-sidebar"
            class="text-right sm:hidden"
            @click="$emit('open-sidebar')"
        >
            <i class="fa fa-list text-2xl"></i>
        </button>

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
</template>
