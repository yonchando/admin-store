<script setup>
import Button from "@/Components/Buttons/Button.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import { ref, Transition } from "vue";

const props = defineProps({
    label: String,
    pt: {
        type: [String, Array],
        validator(value, props) {
            console.log(props);
        },
    },
    show: Boolean,
});

const isShow = ref(props.show);

function toggleShow() {
    isShow.value = !isShow.value;
}
</script>

<template>
    <slot name="button" :toggleClick="toggleShow" :isShow="isShow">
        <PrimaryButton>
            {{ label }}
        </PrimaryButton>
    </slot>

    <Transition>
        <div v-if="isShow" v-bind="$attrs">
            <slot />
        </div>
    </Transition>
</template>

<style scoped>
.v-enter-active {
    animation: collapse-out 0.5s ease-in-out;
    overflow: hidden;
}

.v-leave-active {
    animation: collapse-in 0.3s ease-in-out;
    overflow: hidden;
}

@keyframes collapse-out {
    from {
        max-height: 0;
    }
    to {
        max-height: 1080px;
    }
}

@keyframes collapse-in {
    from {
        max-height: 1080px;
    }
    to {
        max-height: 0;
    }
}
</style>
