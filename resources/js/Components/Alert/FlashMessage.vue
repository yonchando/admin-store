<script setup>
defineProps(['message']);

const types = {
    success: 'alert-success',
    danger: 'alert-danger',
    info: 'alert-info',
    primary: 'alert-primary'
}
</script>

<template>
    <div
        v-if="$page.props.flash.message && !message"
        class="alert"
        :class="types[$page.props.flash.message.type]"
    >
        {{ $page.props.flash.message.text }}
    </div>

    <div
        v-if="!$page.props.flash.message && message"
        class="alert alert-success"
    >
        {{ message }}
    </div>

</template>