<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";

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
        <div class="flex w-full flex-col gap-4">
            <div class="mx-auto w-40 overflow-hidden rounded-full">
                <img
                    class="w-full"
                    src="/assets/images/logos/logo.png"
                    alt="Logo"
                />
            </div>
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4 rounded border p-4 shadow">
                    <div class="pb-5 pt-2 text-center text-xl font-semibold">
                        <span class="d-block text-muted"
                            >Login credentials</span
                        >
                    </div>

                    <div v-if="form.errors.username">
                        <div class="mb-4 text-sm font-medium text-danger">
                            {{ form.errors.username }}
                        </div>
                    </div>

                    <div>
                        <TextInput
                            type="text"
                            name="username"
                            v-model="form.username"
                            placeholder="Username"
                            icon="icon-user"
                        />
                    </div>

                    <div>
                        <TextInput
                            type="password"
                            name="password"
                            v-model="form.password"
                            placeholder="Password"
                            icon="icon-lock2"
                        />
                    </div>

                    <div
                        class="form-group d-flex align-items-center tw-justify-between"
                    >
                        <div class="">
                            <Checkbox
                                name="remember"
                                id="remember"
                                v-model="form.remember"
                                label="Remember"
                            />
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
        </div>
    </GuestLayout>
</template>
