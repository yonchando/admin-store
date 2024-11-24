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
import _ from "lodash";
import { Customer } from "@/types/models/customer";
import { Gender } from "@/types";

const props = defineProps<{
    customer: Customer;
    statuses: [];
    gender: Gender[];
}>();

const form: any = useForm({
    name: "",
    email: "",
    phone_number: "",
    password: "",
    password_confirmation: "",
    profile: "",
    gender: "",
    status: "active",
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
            router.get(route("customer.index"));
        },
        ...cancel.props,
    };
    return [save, cancel];
});

function submit() {
    if (props.customer) {
        form.transform((value: any) => {
            return {
                ...value,
                _method: "PUT",
            };
        }).post(route("customer.update", props.customer.id));
    } else {
        form.post(route("customer.store"));
    }
}

onMounted(() => {
    if (props.customer) {
        for (let key in props.customer) {
            if (key in form) {
                if (key !== "profile") form[key] = props.customer[key as keyof Customer];
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
                                <TextInput label="Email" v-model="form.email" tabindex="3" type="email" />
                                <InputError :message="form.errors.email" />
                            </div>
                            <div class="">
                                <Select label="Gender" v-model="form.gender" :options="gender" :show-search="false" />
                                <InputError :message="form.errors.gender" />
                            </div>
                            <div class="">
                                <Select label="Status" v-model="form.status" :options="statuses" :show-search="false" />
                                <InputError :message="form.errors.status" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <div class="">
                                <TextInput required label="Phone number" v-model="form.phone_number" tabindex="2" />
                                <InputError :message="form.errors.phone_number" />
                            </div>
                            <div class="w-full">
                                <FileUpload label="Feature image" class="mt-auto" v-model="form.profile" />
                                <InputError :message="form.errors.profile" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AppLayout>
</template>

<style scoped></style>
