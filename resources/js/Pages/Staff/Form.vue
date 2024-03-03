<script setup>
import {Head, useForm} from "@inertiajs/vue3";

import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Card from "@/Components/Card/Card.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";

const {staff} = defineProps(['lang', 'staff', 'gender']);

const form = useForm({
    name: staff?.name,
    username: staff?.username,
    password: null,
    password_confirmation: null,
    gender: staff?.gender,
});

const save = () => {
    if (staff) {
        form.patch(route('staff.update', staff), {
            onFinish: () => form.reset()
        })
    } else {
        form.post(route('staff.store'), {
            onFinish: () => form.reset('password_confirmation', 'password')
        });
    }
}

</script>

<template>
    <Head :title="lang.staffs"/>

    <form @submit.prevent="save()">
        <AppLayout>
            <template #breadcrumb>
                <BreadcrumbItem :href="route('staff.index')" :title="lang.staffs"/>
                <BreadcrumbItem :title="lang.add"/>
            </template>

            <template #action>
                <PrimaryButton type="submit" :disabled="form.processing">
                    <i class="icon-floppy-disk"></i>
                    {{ lang.save }}
                </PrimaryButton>
            </template>

            <Card :title="staff ? lang.edit_staff : lang.create_staff">
                <div class="row">
                    <div class="col-6">
                        <FormGroup>
                            <InputLabel :value="lang.username"/>

                            <TextInput v-model="form.username"/>

                            <InputError :message="form.errors.username"/>
                        </FormGroup>
                        <FormGroup>
                            <InputLabel :value="lang.password"/>

                            <TextInput type="password" v-model="form.password"/>

                            <InputError :message="form.errors.password"/>
                        </FormGroup>
                        <FormGroup>
                            <InputLabel :value="lang.password_confirmation"/>

                            <TextInput type="password" v-model="form.password_confirmation"/>

                            <InputError :message="form.errors.password_confirmation"/>
                        </FormGroup>
                    </div>

                    <div class="col-6">
                        <FormGroup>
                            <InputLabel :value="lang.name"/>

                            <TextInput v-model="form.name"/>

                            <InputError :message="form.errors.name"/>
                        </FormGroup>
                        <FormGroup>
                            <InputLabel :value="lang.gender"/>

                            <SelectInput v-model="form.gender" :items="gender" :text="(item) => lang[item.text]"
                                         hide-search/>

                            <InputError :message="form.errors.gender"/>
                        </FormGroup>
                    </div>
                </div>
            </Card>
        </AppLayout>
    </form>

</template>

<style scoped>

</style>
