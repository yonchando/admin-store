<script setup>
import FormGroup from "@/Components/Form/FormGroup.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import TextInput from "@/Components/Form/TextInput.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import WarningButton from "@/Components/Button/WarningButton.vue";
import InputError from "@/Components/Form/InputError.vue";

const { filter } = defineProps({
    categories: {
        type: Array,
        default: [],
    },
    statuses: {
        type: Array,
        default: [],
    },
    filter: {
        type: Object,
        default: [],
    },
    errors: {
        type: Object,
    },
});

const lang = usePage().props.lang;

const form = useForm({
    search: filter?.search ?? null,
    category_id: filter?.category_id ?? null,
    min_price: filter?.min_price ?? null,
    max_price: filter?.max_price ?? null,
    status: filter?.status ?? null,
});

const filters = () => {
    form.get(route("product.index"));
};
</script>

<template>
    <form @submit.prevent="filters">
        <fieldset class="tw-mb-4">
            <h5>{{ lang.filters }}</h5>
        </fieldset>
        <div class="row">
            <div class="col-6">
                <FormGroup>
                    <InputLabel :value="lang.search" />

                    <TextInput v-model="form.search" />
                    <InputError :message="errors.search" />
                </FormGroup>

                <div class="row">
                    <div class="col-6">
                        <FormGroup>
                            <InputLabel :value="lang.price_from" />

                            <TextInput v-model="form.min_price" />
                            <InputError :message="errors.min_price" />
                        </FormGroup>
                    </div>
                    <div class="col-6">
                        <FormGroup>
                            <InputLabel :value="lang.price_to" />

                            <TextInput v-model="form.max_price" />
                            <InputError :message="errors.max_price" />
                        </FormGroup>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <FormGroup>
                    <InputLabel :value="lang.category" />

                    <SelectInput
                        v-model="form.category_id"
                        :items="categories"
                        text="category_name"
                    >
                    </SelectInput>
                    <InputError :message="errors.category_id" />
                </FormGroup>

                <FormGroup>
                    <InputLabel :value="lang.status" />

                    <SelectInput
                        v-model="form.status"
                        :items="statuses"
                        hide-search
                    >
                    </SelectInput>
                    <InputError :message="errors.status" />
                </FormGroup>
            </div>
        </div>

        <form-group>
            <PrimaryButton type="sumbit" class="tw-mr-2">
                <i class="icon-filter3"></i>
                {{ lang.filter }}
            </PrimaryButton>
            <WarningButton :href="route('product.index')">
                <i class="fa fa-trash-alt"></i>
                {{ lang.clear }}
            </WarningButton>
        </form-group>
    </form>
</template>

<style scoped></style>
