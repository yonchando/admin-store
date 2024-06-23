<script setup>
import useMenu from "@/menu.js";
import Nav from "@/Layouts/Partials/Nav.vue";
import { computed, reactive, ref } from "vue";

const emit = defineEmits(["close-sidebar", "expandChange"]);

const props = defineProps({
    mobileExpand: Boolean,
});

const menus = useMenu();

const config = reactive({
    mobileExpand: props.mobileExpand,
});

const navbar = ref();

const sideBarClass = computed(() => {
    let className;
    if (!config.mobileExpand) {
        className = ["w-64","md:w-auto","md:min-w-64", "expand-in"];
    } else {
        className = ["w-full", "expand-out"];
    }

    return className;
});

function toggleExpand() {
    config.mobileExpand = !config.mobileExpand;
    emit("expandChange");
}

defineExpose({
    navbar,
});
</script>

<template>
    <div
        ref="navbar"
        class="min-h-screen bg-dark-400 shadow"
        :class="sideBarClass"
    >
        <div
            class="flex items-center justify-between border-y border-b-white/10 border-t-transparent bg-dark-600 px-1 text-white sm:hidden"
        >
            <button @click="$emit('close-sidebar')" class="px-5 py-3.5">
                <i class="icon-arrow-left8"></i>
            </button>

            YON Chando

            <button @click="toggleExpand" class="px-5 py-3.5">
                <span :class="[!config.mobileExpand ? 'hidden' : '']">
                    <i class="icon-screen-normal"></i>
                </span>
                <span :class="[config.mobileExpand ? 'hidden' : '']">
                    <i class="icon-screen-full"></i>
                </span>
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
