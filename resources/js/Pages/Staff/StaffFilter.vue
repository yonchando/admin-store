<script setup>
import Card from "@/Components/Cards/Card.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import SelectInput from "@/Components/Forms/SelectInput.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import WarningButton from "@/Components/Buttons/WarningButton.vue";

const lang = usePage().props.lang;

const { filters, gender } = defineProps({
    filters: Object,
    gender: Object,
    statuses: Object,
});

const form = useForm({
    search_text: filters?.search_text,
    gender: filters?.gender,
    status: filters?.status,
});

const filter = () => {
    form.get(route("staff.index"), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Card no-header>
        <form @submit.prevent="filter">
            <fieldset>
                <h5>{{ lang.filter }}</h5>
            </fieldset>

            <div class="row tw-mt-2">
                <div class="col-6">
                    <FormGroup>
                        <InputLabel :value="lang.search" />

                        <TextInput v-model="form.search_text" />
                    </FormGroup>

                    <FormGroup>
                        <InputLabel :value="lang.status" />

                        <SelectInput
                            :items="statuses"
                            v-model="form.status"
                            :placeholder="lang.all"
                            hide-search
                        />
                    </FormGroup>
                </div>

                <div class="col-6">
                    <FormGroup>
                        <InputLabel :value="lang.gender" />

                        <SelectInput
                            :items="gender"
                            v-model="form.gender"
                            hide-search
                            :placeholder="lang.all"
                            :text="(item) => lang[item.text]"
                        />
                    </FormGroup>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <PrimaryButton type="submit" class="tw-mr-2">
                        <i class="icon-filter3"></i>
                        {{ lang.filter }}
                    </PrimaryButton>

                    <WarningButton :href="route('staff.index')">
                        <i class="icon-x"></i>
                        {{ lang.clear }}
                    </WarningButton>
                </div>
            </div>
        </form>
    </Card>
</template>

<style scoped></style>
