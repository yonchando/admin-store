<script setup>
import NavLink from "@/Components/Navbar/NavLink.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";
</script>

<template>

    <div class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="navbar-brand tw-py-0">
            <NavLink :href="route('dashboard')" class="d-inline-block">
                <ApplicationLogo width="120" height="50"/>
            </NavLink>
        </div>

        <div class="d-md-none">
            <button
                class="navbar-toggler sidebar-mobile-main-toggle"
                type="button"
            >
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">
            <Dropdown
                class="nav-item dropdown-user"
            >
                <template v-slot:toggle>
                    <DropdownToggle class="navbar-nav-link d-flex align-items-center dropdown-toggle">
                        <img
                            src="/assets/limitless_theme/images/image.png"
                            class="rounded-circle mr-2 tw-w-8"
                            alt=""
                        />
                        <span>{{ $page.props.auth?.user.name }}</span>
                    </DropdownToggle>
                </template>

                <DropdownLink
                    :href="route('profile.edit')"
                    title="Profile"
                />
                <DropdownLink
                    :href="route('logout')"
                    method="post"
                    title="Logout"
                    as="button"
                />
            </Dropdown>
        </div>
    </div>

</template>

<style scoped></style>
