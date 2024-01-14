<script setup>

import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {inject} from "vue";

const {url, text} = defineProps(['url', 'text']);

const lang = usePage().props.lang;

const swal = inject("$swal");

const $emit = defineEmits('change');

const destroy = function () {

    $emit('change')

    swal({
        title: lang.are_you_sure,
        text: lang.do_you_want_to_delete_this.replace(
            ":attribute",
            text,
        ),
        icon: "warning",
        confirmButtonClass: "btn btn-danger",
    }).then((res) => {
        if (res.value) {
            useForm({}).delete(url);
        }
    });
}
</script>

<template>
    <DropdownLink type="button" @click="destroy()">
        <i class="icon-trash"></i>
        {{ lang.delete }}
    </DropdownLink>
</template>

<style scoped>

</style>