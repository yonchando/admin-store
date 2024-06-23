<script setup>
const props = defineProps({
    inline: {
        type: Boolean
    }
});

const className = [
    "flex",
    "gap-2"
];

if(!props.inline){
    className.push('flex-col');
}
</script>

<template>
    <div :class="className">
        <slot/>
    </div>
</template>

<style scoped>

</style>
