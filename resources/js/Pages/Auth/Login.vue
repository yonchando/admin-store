<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    errors: Object
});

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        
        <form class="login-form" @submit.prevent="submit">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                        <h5 class="mb-0">Login</h5>
                        <span class="d-block text-muted">Your credentials</span>
                    </div>
                    
                    <div class="form-group">
                        <div v-if="status" class="tw-mb-4 tw-font-medium tw-text-sm tw-text-green-600">
                            {{ status }}
                        </div>

                        <div v-if="errors.password" class="tw-mb-4 tw-font-medium tw-text-sm text-danger">
                            {{ errors.password }}
                        </div>
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="text"
                               name="username"
                               v-model="form.username"
                               class="form-control" placeholder="Username">
                        <div class="form-control-feedback">
                            <i class="icon-user text-muted"></i>
                        </div>
                        <span class="text-danger"></span>
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="password"
                               name="password"
                               v-model="form.password"
                               class="form-control" placeholder="Password">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                        <span class="text-danger"></span>
                    </div>

                    <div class="form-group d-flex tw-justify-between align-items-center">
                        <div class="form-check mb-0 tw-pl-0">
                            <label class="form-check-label">
                                <Checkbox name="remember" v-model:checked="form.remember"/>
                                Remember
                            </label>
                        </div>
                        <br>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            Forgot your password?
                        </Link>
                    </div>

                    <div class="form-group">
                        <button type="submit"
                                :disabled="form.processing"
                                class="btn btn-primary btn-block">
                            Sign in
                            <i class="icon-circle-right2 ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
