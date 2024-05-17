<script setup>
import NavLink from "@/Components/Navbar/NavLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { ref } from "vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";

const open = ref(false);
</script>

<template>
    <div
        class="inset-x-0 top-0 grid grid-cols-2 items-center justify-between bg-dark p-2 text-white sm:fixed"
    >
        <div class="">
            <NavLink :href="route('dashboard')" class="d-inline-block">
                <ApplicationLogo width="120" height="50" />
            </NavLink>
        </div>

        <button class="text-right sm:hidden" @click="open = !open">
            <i class="fa fa-list text-2xl"></i>
        </button>

        <div
            class="col-span-2 hidden h-full items-center sm:col-span-1 sm:flex sm:justify-self-end"
        >
            <Dropdown class="relative w-full">
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
                    :title="$lang.profile"
                    icon="fa fa-user"
                    :href="route('profile.edit')"
                />
                <dropdown-link
                    :title="$lang.logout"
                    method="post"
                    icon="fa fa-arrow-right-from-bracket"
                    :href="route('logout')"
                />
            </Dropdown>
        </div>
    </div>
</template>
