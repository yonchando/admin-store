<script setup>
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import Card from "@/Components/Card/Card.vue";
import FileInput from "@/Components/Form/FileInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const { lang, product, categories } = defineProps([
    "lang",
    "product",
    "categories",
]);

const form = useForm({
    product_name: product ? product.product_name : null,
    category_id: product ? product.category_id : null,
    price: product ? product.price : null,
    stock: product ? product.stock_quantity : null,
    description: product ? product.description : null,
    image: product ? product.image : null,
});

const save = () => {
    if (product) {
        form.patch(route("product.update", update));
        return;
    }

    form.post(route("product.store"));
};
</script>

<template>
    <Head v-if="product == null" title="Prodcut Add" />
    <Head v-else title="Prodcut Edit" />

    <form @submit.prevent="save()" enctype="multipart/form-data">
        <AppLayout>
            <template #action>
                <PrimaryButton type="submit">
                    <i class="icon-floppy-disk"></i>
                    <span>{{ lang.save }}</span>
                </PrimaryButton>
            </template>

            <template #breadcrumb>
                <BreadcrumbItem
                    icon="icon-box"
                    :href="route('product.index')"
                    :title="lang.products"
                />
                <BreadcrumbItem
                    :icon="product ? 'icon-pencil7' : 'icon-plus2'"
                    :title="product ? lang.prodcut_edit : lang.product_create"
                />
            </template>

            <Card :title="product ? lang.prodcut_edit : lang.product_create">
                <div class="row">
                    <div class="col-8">
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
                    <div class="col-4">
                        <div class="form-group">
                            <fieldset>Product Image</fieldset>
                            <FileInput name="image" v-model="form.image" />
                        </div>
                    </div>
                </div>
            </Card>
        </AppLayout>
    </form>
</template>

<style scoped></style>
