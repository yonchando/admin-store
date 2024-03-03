<script setup>
import {router} from "@inertiajs/vue3";

const {product} = defineProps({
    product: Object,
});

const updateStatus = () => {
    router.patch(route('product.update.status', product));
}
</script>

<template>
    <button :class="{
        'badge-primary': product.status === 'active',
        'badge-danger': product.status !== 'active',
    }"
            @click="updateStatus"
            class="badge text-uppercase focus:tw-outline-0">
        {{ product.status_text }}
    </button>
</template>

<style scoped>

</style>
