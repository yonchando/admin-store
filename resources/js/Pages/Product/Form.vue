<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import useAction from "@/services/action.service";

const show = defineModel("show");

const form = useForm({
    name: "",
});

const actions = computed(() => {
    const { save, close } = useAction();

    save.props.onClick = submit;

    close.props.onClick = (e) => {
        show.value = false;
    };

    return [save, close];
});

function submit() {}
</script>

<template>
    <Modal :actions="actions" :show="!!show" title="Add new" max-width="xl" position="center">
        <div>
            <form class="space-y-4">
                <TextInput label="Name" v-model="form.name" />
            </form>
        </div>
    </Modal>
</template>

<style scoped></style>
