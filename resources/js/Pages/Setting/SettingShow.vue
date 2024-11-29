<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Setting } from "@/types/models/setting";
import useAction from "@/services/action.service";
import TextInput from "@/Components/Forms/TextInput.vue";
import InputError from "@/Components/Forms/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import FileUpload from "@/Components/Forms/FileUpload.vue";
import Select from "@/Components/Forms/Select.vue";
import { Currency } from "@/types/currency";
import { onMounted } from "vue";
import _, { set } from "lodash";

const props = defineProps<{
    settings: Setting[];
    currencies: Currency[];
}>();

const form: any = useForm({
    site_title: "",
    logo: "",
    currency: "",
});

const { save, refresh } = useAction();

const actions = [save, refresh];

onMounted(() => {
    for (const setting of props.settings) {
        if (setting.key in form) {
            form[setting.key] = setting.value;
        }
    }
});
</script>

<template>
    <AppLayout title="Setting" :actions="actions">
        <template #header> Settings </template>

        <div class="p-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-4">
                    <div class="">
                        <TextInput required label="Name" v-model="form.site_title" />
                        <InputError :message="form.errors.site_title" />
                    </div>
                    <div class="">
                        <Select
                            :options="currencies"
                            v-model="form.currency"
                            :show-search="false"
                            option-label="code" />
                        <InputError :message="form.errors.site_title" />
                    </div>
                </div>

                <div class="">
                    <FileUpload v-model="form.logo" label="Logo" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
