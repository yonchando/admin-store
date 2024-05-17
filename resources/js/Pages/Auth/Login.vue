<script setup>
import Checkbox from "@/Components/Form/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    username: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout title="Login">
        <form @submit.prevent="submit">
            <div class="flex flex-col gap-4 rounded-md p-4 shadow border">
                <div class="text-center">
                    <img
                        class="mx-auto w-1/4"
                        src="/assets/images/logos/logo.png"
                        alt="Logo"
                    />
                    <h5 class="mb-0 text-3xl font-bold">Login</h5>
                    <span class="d-block text-muted">Your credentials</span>
                </div>

                <div class="mb-4">
                    <div
                        v-if="form.errors.username"
                        class="mb-4 text-sm font-medium text-danger"
                    >
                        {{ form.errors.username }}
                    </div>
                </div>

                <div class="mb-4">
                    <TextInput
                        type="text"
                        name="username"
                        v-model="form.username"
                        placeholder="Username"
                    />
                    <div class="form-control-feedback">
                        <i class="icon-user text-muted"></i>
                    </div>
                    <span class="text-danger"></span>
                </div>

                <div class="mb-4">
                    <TextInput
                        type="password"
                        name="password"
                        v-model="form.password"
                        placeholder="Password"
                    />
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                    <span class="text-danger"></span>
                </div>

                <div
                    class="form-group d-flex align-items-center tw-justify-between"
                >
                    <div class="form-check tw-pl-0 mb-0">
                        <label for="remember" class="form-check-label">
                            <Checkbox
                                name="remember"
                                id="remember"
                                v-model:checked="form.remember"
                            />
                            Remember
                        </label>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <PrimaryButton
                        type="submit"
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Sign in
                        <i class="icon-circle-right2 ml-2"></i>
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
