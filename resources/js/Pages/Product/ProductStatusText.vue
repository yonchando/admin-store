<script setup>
import axios from "axios";

const {product} = defineProps({
    product: Object,
});

const updateStatus = () => {
    axios.patch(route('product.update.status', product))
        .then(res => {
            const data = res.data?.product;
            product.status = data.status;
            product.status_text = data.status_text
        })
}
</script>

<template>
    <button :class="{
        'badge-primary': product.status === 'ACTIVE',
        'badge-danger': product.status !== 'ACTIVE',
    }"
            @click="updateStatus()"
            class="badge text-uppercase">
        {{ product.status_text }}
    </button>
</template>

<style scoped>

</style>