<script setup>

import FormGroup from "@/Components/Form/FormGroup.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/Form/TextInput.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";

defineProps({
    categories: {
        type: Array,
        default: [],
    },
    statuses: {
        type: Array,
        default: [],
    }
})

const lang = usePage().props.lang;

const form = useForm({
    search: null,
    category_id: null,
    min_price: null,
    max_price: null,
});

</script>

<template>
    <fieldset class="tw-mb-4">
        <h5>{{ lang.filters }}</h5>
    </fieldset>
    <div class="row">
        <div class="col-6">
            <FormGroup>
                <InputLabel :value="lang.search"/>

                <TextInput v-model="form.search"/>
            </FormGroup>

            <div class="row">
                <div class="col-6">
                    <FormGroup>
                        <InputLabel :value="lang.price_from"/>

                        <TextInput v-model="form.min_price"/>
                    </FormGroup>
                </div>
                <div class="col-6">
                    <FormGroup>
                        <InputLabel :value="lang.price_to"/>

                        <TextInput v-model="form.max_price"/>
                    </FormGroup>
                </div>
            </div>
        </div>
        <div class="col-6">
            <FormGroup>
                <InputLabel :value="lang.category"/>

                <SelectInput v-model="form.category_id"
                             :items="categories"
                             text="category_name">

                </SelectInput>
            </FormGroup>

            <FormGroup>
                <InputLabel :value="lang.status"/>

                <SelectInput v-model="form.status"
                             :items="statuses"
                             text="category_name">

                </SelectInput>
            </FormGroup>
        </div>
    </div>
</template>

<style scoped>

</style>