<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import useActions from "@/actions.js";
import InputLabel from "@/Components/Forms/InputLabel.vue";

const { lang, product, categories } = defineProps([
    "lang",
    "product",
    "categories",
    "groups",
    "options",
]);

const form = useForm({
    product_name: product ? product.product_name : "",
    category_id: product ? product.category_id : "",
    price: product ? product.price : "",
    stock: product ? product.stock_quantity : "",
    description: product ? product.description : "",
    image: product ? product.image : "",
    product_options: [
        {
            product_option_group_id: "",
            options: [
                {
                    product_option_id: "",
                    price_adjustment: "",
                },
            ],
        },
    ],
});

const actions = computed(() =>
    useActions({
        save: () => {
            save();
        },
    }),
);

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
    <AppLayout
        :title="product ? 'Product Add' : 'Product Edit'"
        :actions="actions"
    >
        <div class="flex flex-col gap-2">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-8 flex flex-col gap-4">
                    <div class="grid grid-cols-2 gap-4">
                        <FormGroup>
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
                        </FormGroup>

                        <FormGroup>
                            <InputLabel
                                for="category_name"
                                required
                                :value="lang.category"
                            />

                            <SelectInput
                                name="category_id"
                                :options="categories"
                                input-id="category_name"
                                v-model="form.category_id"
                                option-label="category_name"
                                option-id="id"
                            />
                        </FormGroup>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <FormGroup>
                            <InputLabel for="price" :value="lang.price" />

                            <TextInput
                                name="price"
                                id="price"
                                v-model="form.price"
                            />
                        </FormGroup>

                        <FormGroup>
                            <InputLabel
                                for="stock_quantity"
                                :value="lang.stock_quantity"
                            />

                            <TextInput
                                name="category_id"
                                id="stock_quantity"
                                v-model="form.stock"
                            />
                        </FormGroup>
                    </div>
                </div>
                <div class="col-span-3">
                    <FormGroup>
                        <InputLabel>Product Image</InputLabel>
                        <FileInput name="image" v-model="form.image" />
                    </FormGroup>
                </div>
            </div>
            <div class="flex w-full flex-col gap-4 mt-4">
                <InputLabel
                    for="description"
                    required
                    :value="lang.description"
                />
                
                <Editor />
            </div>
        </div>
    </AppLayout>
</template>
