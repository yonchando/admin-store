<script setup>
import NavLink from "@/Components/NavLink.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import {reactive} from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";


const menuState = reactive({
    isOpen: false
})

</script>

<template>
    <section>
        <div class="navbar navbar-expand-md navbar-dark fixed-top">
            <div class="navbar-brand tw-py-0">
                <NavLink :href="route('dashboard')" class="d-inline-block">
                    <ApplicationLogo width="120" height="60"/>
                </NavLink>
            </div>

            <div class="d-md-none">
                <button class="navbar-toggler sidebar-mobile-main-toggle"
                        @click="menuState.isOpen = !menuState.isOpen"
                        type="button">
                    <i class="icon-paragraph-justify3"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse"
                 :class="{'show': menuState.isOpen}"
                 id="navbar-mobile">
                <ul class="navbar-nav ml-auto">
                    <Dropdown class="nav-item dropdown-user" toggle-class="navbar-nav-link d-flex align-items-center dropdown-toggle">
                        <template v-slot:toggle>
                            <img src="../../../assets/limitless_theme/images/image.png"
                                 class="rounded-circle mr-2" height="34" alt="">
                            <span>{{ $page.props.auth?.user.name }}</span>
                        </template>

                        <DropdownLink :href="route('profile.edit')" title="Profile"/>
                        <DropdownLink :href="route('logout')" method="post" title="Logout"/>
                    </Dropdown>
                </ul>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>