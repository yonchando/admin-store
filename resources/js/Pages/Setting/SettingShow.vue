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
import { computed, onMounted } from "vue";
import _, { set } from "lodash";
import Card from "@/Components/Card/Card.vue";

const props = defineProps<{
    settings: Setting[];
    currencies: Currency[];
    formData: object;
    settingKeys: object;
    logo: Setting;
}>();

const form: any = useForm({
    site_title: "",
    logo: "",
    currency: "",
    ...props.formData,
});

const actions = computed(() => {
    const { save } = useAction();

    save.props.onClick = () => {
        form.post(route("setting.update"));
    };

    return [save];
});
</script>

<template>
    <AppLayout title="Setting" :actions="actions">
        <template #header> Settings </template>

        <div class="p-4">
            <div class="max-w-lg">
                <div class="flex flex-col gap-4">
                    <div class="">
                        <TextInput required label="Name" v-model="form.site_title" />
                        <InputError :message="form.errors.site_title" />
                    </div>
                    <div class="">
                        <Select
                            label="Currency"
                            :options="currencies"
                            v-model="form.currency"
                            :show-search="false"
                            option-label="code" />
                        <InputError :message="form.errors.site_title" />
                    </div>
                    <div class="">
                        <FileUpload v-model="form.logo" label="Logo" />
                        <div>
                            <template v-if="logo">
                                <img class="w-full rounded" :src="logo.logo_url" alt="" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
