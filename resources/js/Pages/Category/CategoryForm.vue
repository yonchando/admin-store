<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import useAction from "@/services/action.service";
import InputError from "@/Components/Forms/InputError.vue";
import { Category } from "@/types/models/category";

const show = defineModel("show");
const props = defineProps<{
    category?: Category | null;
}>();

const form = useForm({
    category_name: props.category?.category_name ?? "",
});

const actions = computed(() => {
    const { save, close } = useAction();

    save.props.onClick = submit;

    close.props.onClick = (e) => {
        show.value = false;
    };

    return [save, close];
});

function submit() {
    if (props.category) {
        form.put(route("category.update", props.category?.id), {
            onSuccess: () => {
                show.value = false;
                form.reset();
            },
        });
    } else {
        form.post(route("category.store"), {
            onSuccess: () => {
                show.value = false;
                form.reset();
            },
        });
    }
}
</script>

<template>
    <Modal :actions="actions" :show="!!show" @close="show = false" title="Add new" max-width="xl" class="!top-8">
        <form @submit.prevent="submit">
            <div>
                <TextInput autofocus label="Name" v-model="form.category_name" />
                <InputError :message="form.errors.category_name" />
            </div>
        </form>
    </Modal>
</template>

<style scoped></style>
