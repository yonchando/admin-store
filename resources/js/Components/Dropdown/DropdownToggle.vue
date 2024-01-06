<script setup>
import {ref} from "vue";

const props = defineProps({
    title: String,
    show: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['onToggle']);

let isShow = ref(props.show);

function onToggle() {
    isShow.value = !isShow.value;
    emit("onToggle", isShow.value);

    if (isShow.value) {
        document.addEventListener('keydown', closeOnEscape)
        document.addEventListener('click', closeOnClickOutside)
    } else {
        document.removeEventListener('keydown', closeOnEscape);
        document.removeEventListener('click', closeOnClickOutside)
        document.body.style.overflow = null;
    }
}

const closeOnEscape = (e) => {
    console.log(e.key === 'Escape' && isShow.value);
    if (e.key === 'Escape' && isShow.value) {
        onToggle();
    }
};

const closeOnClickOutside = (e) => {
    var parent = getParent('.dropdown-toggle', e.target.parentNode);

    if (typeof parent === 'undefined' && isShow.value) {
        onToggle();
    }
}

const getParent = (target, node) => {

    if (!node.classList) {
        return;
    }

    if (target[0] === '.' && node.classList.contains(target.slice(1, target.length))) {
        return node;
    }

    if (target[0] === '#' && node.id === target.slice(1, target.length)) {
        return node;
    }
    // if (node.classList.includes(target) || node.id === `#{target}`) {
    //     return node;
    // }
    //

    if (node.parentNode)
        return getParent(target, node.parentNode);
}

</script>

<template>
    <a @click="onToggle()" data-toggle="dropdown">
        <slot>{{ title }}</slot>
    </a>
</template>

<style scoped>

</style>