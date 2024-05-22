<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Cards/Card.vue";
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SelectInput from "@/Components/Forms/SelectInput.vue";
import FlashMessage from "@/Components/Alerts/FlashMessage.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import InputError from "@/Components/Forms/InputError.vue";
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";

const { lang, setting } = defineProps(["lang", "setting", "currencies"]);

const form = useForm({
    currency_id: setting.properties.currency_id,
});

const update = () => {
    form.put(route("setting.update"));
};
</script>

<template>
    <Head :title="lang.setting" />

    <AppLayout>
        <template #action>
            <PrimaryButton @click="update">
                <i class="fa fa-save"></i>
                {{ lang.save }}
            </PrimaryButton>
        </template>

        <template #breadcrumb>
            <BreadcrumbItem :title="lang.setting" icon="icon-gear" />
        </template>

        <FlashMessage />

        <Card :title="lang.setting">
            <div class="row">
                <div class="col-6">
                    <FormGroup>
                        <InputLabel :value="lang.currency" />

                        <SelectInput
                            v-model="form.currency_id"
                            hide-search
                            :items="currencies"
                            disabled-clear
                            :text="
                                (item) => `${item['name']} - ${item['code']}`
                            "
                        />

                        <InputError :message="form.errors.currency_id" />
                    </FormGroup>
                </div>
            </div>
        </Card>
    </AppLayout>
</template>

<style scoped></style>
