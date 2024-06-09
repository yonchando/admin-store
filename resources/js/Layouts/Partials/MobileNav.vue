<script setup>
import Navbar from "@/Layouts/Partials/Navbar.vue";
import { ref, watch } from "vue";

const emit = defineEmits(["close-sidebar"]);
const props = defineProps({
    show: Boolean,
});

const sidebar = ref();

const mobileExpand = ref(false);

function eventListener(e) {
    const btnToggle = document.querySelector("#btn-open-sidebar");

    if (sidebar != null && btnToggle != null) {
        const navbar = sidebar.value.navbar;
        if (!navbar.contains(e.target) && !btnToggle.contains(e.target)) {
            emit("close-sidebar");
        }
    }
}

watch(
    () => props.show,
    (value) => {
        if (value) {
            document.addEventListener("click", eventListener);
        } else {
            document.removeEventListener("click", eventListener);
        }
    },
);
</script>

<template>
    <Transition
        enter-active-class="transform duration-500 ease-in-out"
        leave-active-class="-translate-x-full transform duration-500 ease-in-out"
        enter-from-class="-translate-x-full transform duration-500 ease-in-out"
        enter-to-class="translate-x-0 transform duration-500 ease-in-out"
    >
        <div class="fixed inset-0 z-50 overflow-auto" v-if="show">
            <Navbar ref="sidebar"
                    :mobile-expand="mobileExpand"
                    @expand-change="mobileExpand = !mobileExpand"
                    @close-sidebar="$emit('close-sidebar')" />
        </div>
    </Transition>
</template>

<style scoped>
.expand-out {
    animation: expand-out 0.2s;
}

.expand-in {
    animation: expand-in 0.2s;
}

@keyframes expand-out {
    from {
        width: 16rem;
    }
    to {
        width: 100%;
    }
}

@keyframes expand-in {
    from {
        width: 100%;
    }
    to {
        width: 16rem;
    }
}
</style>
