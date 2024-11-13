<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, onMounted } from "vue";
import useAction from "@/services/action.service";
import InputError from "@/Components/Forms/InputError.vue";
import { Category } from "@/types/models/category";
import { Module } from "@/types/models/module";
import Select from "@/Components/Forms/Select.vue";

const show = defineModel("show");
const props = defineProps<{
    module?: Module | null;
    statuses: Array<string>;
    permissions: any;
}>();

const form = useForm({
    name: props.module?.name ?? "",
    permissions: [] as Array<any>,
    status: props.module?.status ?? "active",
});

const actions = computed(() => {
    const { save } = useAction();

    save.props.onClick = submit;

    return [save];
});

function submit() {
    if (props.module) {
        form.put(route("module.update", props.module?.id), {
            onSuccess: () => {
                show.value = false;
                form.reset();
            },
        });
    } else {
        form.post(route("module.store"), {
            onSuccess: () => {
                show.value = false;
                form.reset();
            },
        });
    }
}

onMounted(() => {
    if (props.module) {
        form.permissions = props.module.permissions?.map((item) => item.id) as Array<any>;
    }
});
</script>

<template>
    <Modal :actions="actions" v-model:show="show" title="Add new" max-width="xl" class="!top-8">
        <form @submit.prevent="submit">
            <div class="flex flex-col gap-4">
                <div>
                    <TextInput autofocus label="Name" tabindex="1" v-model="form.name" />
                    <InputError :message="form.errors.name" />
                </div>
                <div>
                    <Select
                        tabindex="2"
                        label="Permissions"
                        multiple
                        v-model="form.permissions"
                        :options="permissions"
                        :show-search="false" />
                    <InputError :message="form.errors.permissions" />
                </div>
                <div>
                    <Select
                        tabindex="2"
                        label="Status"
                        v-model="form.status"
                        :options="statuses"
                        :show-search="false" />
                    <InputError :message="form.errors.status" />
                </div>
            </div>
        </form>
    </Modal>
</template>

<style scoped></style>
