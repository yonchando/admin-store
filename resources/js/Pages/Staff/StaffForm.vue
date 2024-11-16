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
import Permission from "@/Components/Permission/Permission.vue";
import { Paginate } from "@/types/paginate";
import { Role } from "@/types/models/role";

const props = defineProps<{
    staff: Staff;
    permissions: number[][];
    statuses: [];
    gender: [];
    roles: Paginate<Role>;
}>();

const form: any = useForm({
    name: "",
    username: "",
    password: "",
    password_confirmation: "",
    gender: "",
    position: "",
    profile: "",
    status: "active",
    permissions: {} as { [key: number]: number[] },
    roles: [] as number[],
});

const disabled = ref<{ [key: number]: number[] }>({});

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
            router.get(route("staff.index"));
        },
        ...cancel.props,
    };
    return [save, cancel];
});

function submit() {
    if (props.staff) {
        form.put(route("staff.update", props.staff.id));
    } else {
        form.post(route("staff.store"));
    }
}

function selectRole() {
    let roles = props.roles.data.filter((item) => form.roles.includes(item.id));

    disabled.value = {};
    for (const role of roles) {
        for (const module_id in role.permission_ids) {
            if (typeof disabled.value[module_id] === "undefined") {
                disabled.value[module_id] = role.permission_ids[module_id];
            } else {
                let permissions = role.permission_ids[module_id] as number[];
                for (const permission of permissions) {
                    if (!disabled.value[module_id].includes(permission)) {
                        disabled.value[module_id].push(permission);
                    }
                }
            }
        }
    }
}

onMounted(() => {
    if (props.staff) {
        for (let key in props.staff) {
            if (key in form) {
                form[key] = props.staff[key as keyof Staff];
            }
        }
    }
});
</script>

<template>
    <AppLayout :actions="actions" title="Create staff">
        <template #header> Create staff</template>
        <form @submit.prevent="submit" method="POST">
            <div class="p-4">
                <div class="flex gap-4">
                    <div class="grid w-full grid-cols-2 gap-4">
                        <div class="flex flex-col gap-4">
                            <div class="">
                                <TextInput required label="Name" v-model="form.name" tabindex="1" />
                                <InputError :message="form.errors.name" />
                            </div>
                            <div class="">
                                <TextInput label="Position" v-model="form.position" tabindex="2" />
                                <InputError :message="form.errors.status" />
                            </div>
                            <div class="">
                                <Select label="Gender" v-model="form.gender" :options="gender" :show-search="false" />
                                <InputError :message="form.errors.status" />
                            </div>
                            <div class="">
                                <Select label="Status" v-model="form.status" :options="statuses" :show-search="false" />
                                <InputError :message="form.errors.status" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <div class="">
                                <TextInput required label="Username" v-model="form.username" tabindex="3" />
                                <InputError :message="form.errors.username" />
                            </div>
                            <div class="">
                                <TextInput
                                    required
                                    label="Password"
                                    type="password"
                                    v-model="form.password"
                                    tabindex="4" />
                                <InputError :message="form.errors.password" />
                            </div>
                            <div class="">
                                <TextInput
                                    tabindex="5"
                                    required
                                    type="password"
                                    label="Password confirmation"
                                    v-model="form.password_confirmation" />
                                <InputError :message="form.errors.password_confirmation" />
                            </div>
                            <div class="w-full">
                                <FileUpload label="Feature image" class="mt-auto" v-model="form.profile" />
                                <InputError :message="form.errors.profile" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h2 class="text-xl">Role</h2>
                    <Select
                        multiple
                        v-model="form.roles"
                        @change="selectRole"
                        :options="roles.data"
                        :paginate="roles"
                        option-label="code"
                        option-value="id" />
                </div>

                <div class="mt-6">
                    <h2 class="text-xl">Permission</h2>
                </div>

                <Permission :values="permissions" :disabled="disabled" v-model="form.permissions" />
            </div>
        </form>
    </AppLayout>
</template>

<style scoped></style>
