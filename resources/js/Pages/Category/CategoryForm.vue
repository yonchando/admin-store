<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, onMounted, reactive, ref } from "vue";
import useAction from "@/services/action.service";
import InputError from "@/Components/Forms/InputError.vue";
import { Category } from "@/types/models/category";
import axios from "axios";
import { Paginate } from "@/types/paginate";
import Select from "@/Components/Forms/Select.vue";
import { usePaginate } from "@/services/helper.service";

const show = defineModel("show");
const props = defineProps<{
    category?: Category | null;
}>();

const processing = reactive({
    options: false,
});

const form = useForm({
    category_name: props.category?.category_name ?? "",
    parent_id: props.category?.parent_id ?? "",
});

const options = ref<Paginate<Category>>(usePaginate());

function getOptions() {
    axios
        .get(route("category.index"))
        .then((res) => {
            options.value = res.data;
        })
        .finally(() => {
            processing.options = false;
        });
}

const actions = computed(() => {
    const { save } = useAction();

    save.props.onClick = submit;

    return [save];
});

const getTitle = computed(() => {
    return props.category ? `Update` : "Create";
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

onMounted(() => {
    getOptions();
});
</script>

<template>
    <Modal :actions="actions" v-model:show="show" @close="show = false" :title="getTitle" max-width="xl" class="!top-8">
        <form @submit.prevent="submit">
            <div class="flex flex-col gap-4">
                <div>
                    <Select
                        v-model="form.parent_id"
                        :options="options.data"
                        :url="options.links.next"
                        option-label="category_name" />
                    <InputError :message="form.errors.category_name" />
                </div>
                <div>
                    <TextInput autofocus label="Name" v-model="form.category_name" required />
                    <InputError :message="form.errors.category_name" />
                </div>
            </div>
        </form>
    </Modal>
</template>

<style scoped></style>
