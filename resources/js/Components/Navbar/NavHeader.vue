<script setup>
defineProps(["label"]);
</script>

<template>
    <div class="px-5 py-3.5 text-white/50">
        <div class="line-height-xs text-xs uppercase leading-7">
            <slot>
                {{ label }}
            </slot>
        </div>
        <i class="icon-menu" :title="label"></i>
    </div>
</template>
