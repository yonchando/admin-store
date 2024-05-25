<script setup>
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Card from "@/Components/Cards/Card.vue";
import FileInput from "@/Components/Forms/FileInput.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SelectInput from "@/Components/Forms/SelectInput.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import InfoButton from "@/Components/Buttons/InfoButton.vue";

const { lang, product, categories } = defineProps([
    "lang",
    "product",
    "categories",
    "groups",
    "options",
]);

const form = useForm({
    product_name: product ? product.product_name : null,
    category_id: product ? product.category_id : null,
    price: product ? product.price : null,
    stock: product ? product.stock_quantity : null,
    description: product ? product.description : null,
    image: product ? product.image : null,
    product_options: [
        {
            product_option_group_id: null,
            options: [
                {
                    product_option_id: null,
                    price_adjustment: null,
                },
            ],
        },
    ],
});

function addGroup() {
    form.product_options.push({
        product_option_group_id: null,
        options: [
            {
                product_option_id: null,
                price_adjustment: null,
            },
        ],
    });
}

const save = () => {
    if (product) {
        form._method = "PATCH";
        router.post(route("product.update", product), form);
        return;
    }

    form.post(route("product.store"));
};
</script>

<template>
    <AppLayout :title="product ? 'Product Add' : 'Product Edit'">
        <form @submit.prevent="save()" enctype="multipart/form-data">
            <Card :title="product ? lang.prodcut_edit : lang.product_create">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <InputLabel
                                        for="product_name"
                                        required
                                        :value="lang.product_name"
                                    />

                                    <TextInput
                                        name="product_name"
                                        id="product_name"
                                        v-model="form.product_name"
                                    />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <InputLabel
                                        for="category"
                                        required
                                        :value="lang.category"
                                    />

                                    <SelectInput
                                        name="category_id"
                                        :items="categories"
                                        id="id"
                                        v-model="form.category_id"
                                        text="category_name"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <InputLabel
                                        for="price"
                                        :value="lang.price"
                                    />

                                    <TextInput
                                        name="price"
                                        id="price"
                                        v-model="form.price"
                                    />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <InputLabel
                                        for="stock_quantity"
                                        :value="lang.stock_quantity"
                                    />

                                    <TextInput
                                        name="category_id"
                                        id="stock_quantity"
                                        v-model="form.stock"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <InputLabel
                                    for="description"
                                    required
                                    :value="lang.description"
                                />
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control"
                                    v-model="form.description"
                                    rows="10"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <fieldset>Product Image</fieldset>
                            <FileInput name="image" v-model="form.image" />
                        </div>
                    </div>
                </div>
            </Card>

            <Card v-if="!product" collapse :title="lang.product_option">
                <template v-for="(group, i) in form.product_options">
                    <Card>
                        <div class="form-group row">
                            <div class="col-6">
                                <InputLabel :value="lang.option_group" />
                                <SelectInput
                                    v-model="group.product_option_group_id"
                                    text="name"
                                    :items="groups"
                                />
                            </div>
                        </div>
                        <div class="form-group tw-grid tw-grid-cols-2 tw-gap-4">
                            <template v-for="option in group.options">
                                <div class="">
                                    <InputLabel :value="lang.options" />
                                    <SelectInput
                                        v-model="option.product_option_id"
                                        text="name"
                                        :items="options"
                                    />
                                </div>
                                <div class="">
                                    <InputLabel
                                        :value="lang.price_adjustment"
                                    />
                                    <TextInput
                                        v-model="option.price_adjustment"
                                        type="number"
                                    />
                                </div>
                            </template>
                        </div>
                        <InfoButton
                            @click="
                                group.options.push({
                                    product_option_id: null,
                                    price_adjustment: null,
                                })
                            "
                        >
                            {{ lang.add_option }}
                        </InfoButton>
                    </Card>
                </template>

                <InfoButton @click="addGroup">
                    {{ lang.add_group }}
                </InfoButton>
            </Card>

            <PrimaryButton type="submit" :disabled="form.processing">
                <i class="icon-floppy-disk"></i>
                <span>{{ lang.save }}</span>
            </PrimaryButton>
        </form>
    </AppLayout>
</template>

<style scoped></style>
