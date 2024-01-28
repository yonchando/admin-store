<script setup>
import {usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";

const props = defineProps({
    message: String,
    popup: {
        type: Boolean,
        default: true
    }
});

const types = {
    success: 'alert-success',
    danger: 'alert-danger',
    info: 'alert-info',
    primary: 'alert-primary'
}

const getMessage = ref(props.message);

const page = usePage();

const timeoutInSecond = 2500;

const flasMessage = computed(() => {
    const message = page.props.flash.message

    if (message != null) {
        setTimeout(() => {
            page.props.flash.message = null;
        }, timeoutInSecond);
    }

    return message;
});

const showMessage = computed(() => {
    if (getMessage) {
        setTimeout(() => {
            getMessage.value = null;
        }, timeoutInSecond);
    }
    return getMessage.value;
})
</script>

<template>
    <Teleport to="body" :disabled="!popup">
        <div :class="{'tw-fixed tw-top-16 tw-right-4 tw-flex tw-flex-col': popup}" v-if="flasMessage || showMessage">
            <div
                v-if="flasMessage"
                class="alert tw-relative tw-pr-28"
                :class="types[$page.props.flash.message?.type]"
            >
                {{ $page.props.flash.message?.text }}
                <i @click="page.props.flash.message = null"
                   class="fa fa-times tw-absolute tw-right-4 tw-top-1/2 -tw-translate-y-1/2 tw-cursor-pointer text-secondary"></i>
            </div>

            <div
                v-if="showMessage"
                class="alert alert-success tw-relative tw-pr-28"
            >
                {{ getMessage }}
                <i @click="getMessage = null"
                   class="fa fa-times tw-absolute tw-right-4 tw-top-1/2 -tw-translate-y-1/2 tw-cursor-pointer text-secondary"></i>
            </div>
        </div>
    </Teleport>
</template>