<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import FileUpload from "@/Components/Forms/FileUpload.vue";
import InputError from "@/Components/Forms/InputError.vue";
import Select from "@/Components/Forms/Select.vue";
import { router, useForm } from "@inertiajs/vue3";
import useAction from "@/services/action.service";
import { computed, onMounted, ref } from "vue";
import { Staff } from "@/types/models/staff";
import { Role } from "@/types/models/role";
import { Module } from "@/types/models/module";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import Permission from "@/Components/Permission/Permission.vue";

const props = defineProps<{
    role: Role;
    statuses: [];
    gender: [];
    modules: Module[];
    permissions: { [key: number]: number[] };
}>();

const form: any = useForm({
    code: "",
    name: "",
    status: "active",
    permissions: {} as { [key: number]: number[] },
});

const actions = computed(() => {
    const { save, cancel } = useAction();
    save.props = {
        onClick() {
            submit();
        },
        tabindex: "6",
        ...save.props,
    };

    cancel.props = {
        onClick() {
            router.get(route("role.index"));
        },
        ...cancel.props,
    };
    return [save, cancel];
});

function submit() {
    if (props.role) {
        form.put(route("role.update", props.role.id));
    } else {
        form.post(route("role.store"));
    }
}

onMounted(() => {
    if (props.role) {
        Object.keys(props.role).forEach((key) => {
            if (typeof form[key] !== "undefined" && key !== "permissions") {
                form[key] = props.role[key as keyof Role];
            }
        });
    }
});
</script>

<template>
    <AppLayout :actions="actions" title="Create staff">
        <template #header>
            <template v-if="!role"> Create role </template>
            <span v-else> Update role </span>
        </template>
        <form @submit.prevent="submit" method="POST">
            <div class="p-4">
                <div class="flex gap-4">
                    <div class="grid w-full grid-cols-2 gap-4">
                        <div class="flex flex-col gap-4">
                            <div class="">
                                <TextInput required label="Code" v-model="form.code" tabindex="1" />
                                <InputError :message="form.errors.code" />
                            </div>
                            <div class="">
                                <Select label="Status" v-model="form.status" :options="statuses" :show-search="false" />
                                <InputError :message="form.errors.status" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <div class="">
                                <TextInput required label="Name" v-model="form.name" tabindex="3" />
                                <InputError :message="form.errors.name" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h2 class="text-xl">Permission</h2>
                </div>

                <Permission :values="props.permissions" :modules="modules" v-model="form.permissions" />
            </div>
        </form>
    </AppLayout>
</template>

<style scoped></style>
