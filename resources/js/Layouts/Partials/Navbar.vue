<script setup>
import useMenu from "@/menu.js";
import Nav from "@/Layouts/Partials/Nav.vue";
import { reactive, ref } from "vue";

defineEmits(["close-sidebar"]);

const menus = useMenu();

const config = reactive({
    mobileExpand: false,
});

const sideBarClass = ref(["min-w-64", "w-64", "sm:w-auto"]);

function toggleExpand() {
    if (config.mobileExpand) {
        sideBarClass.value = ["w-64", "expand-in"];
        config.mobileExpand = false;
    } else {
        sideBarClass.value = ["w-full", "expand-out"];
        config.mobileExpand = true;
    }
}
</script>

<template>
    <div class="min-h-screen bg-dark-400 shadow" :class="sideBarClass">
        <div
            class="flex items-center justify-between border-y border-b-white/10 border-t-transparent bg-dark-600 px-1 text-white sm:hidden"
        >
            <button @click="$emit('close-sidebar')" class="px-5 py-3.5">
                <i class="icon-arrow-left8"></i>
            </button>

            YON Chando

            <button @click="toggleExpand" class="px-5 py-3.5">
                <i
                    :class="[!config.mobileExpand ? 'hidden' : '']"
                    class="icon-screen-normal"
                ></i>
                <i
                    :class="[config.mobileExpand ? 'hidden' : '']"
                    class="icon-screen-full"
                ></i>
            </button>
        </div>

        <div class="my-4 flex justify-center p-2">
            <div class="h-32 w-32 overflow-hidden rounded-full">
                <img
                    class="h-auto w-full"
                    src="/assets/images/logos/logo.png"
                    alt="Logo"
                />
            </div>
        </div>

        <div class="text-white">
            <div class="flex flex-col" data-nav-type="accordion">
                <Nav :menus="menus" />
            </div>
        </div>
    </div>
</template>
