<script setup lang="ts">
import TextInput from "@/Components/Forms/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import useAction from "@/services/action.service";
import AppLayout from "@/Layouts/AppLayout.vue";
import TextareaInput from "@/Components/Forms/TextareaInput.vue";
import InputError from "@/Components/Forms/InputError.vue";
import Select from "@/Components/Forms/Select.vue";
import { Product } from "@/types/models/product";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import FileUpload from "@/Components/Forms/FileUpload.vue";

const props = defineProps<{
    statuses: Array<string>;
    product?: Product;
}>();

const product = props.product;

const form = useForm({
    product_name: product?.product_name ?? "",
    price: product?.price ?? "",
    stock_qty: product?.stock_qty ?? "",
    category_id: product?.category_id ?? "",
    status: product?.status ?? "",
    description: product?.description ?? "",
    image: "",
});

const actions = computed(() => {
    const { save, cancel } = useAction();

    save.props.onClick = submit;

    cancel.props.onClick = () => {
        router.get(route("product.index"));
    };

    return [save, cancel];
});

function submit() {
    if (product) {
        form.transform((data: any) => {
            return {
                ...data,
                _method: "PUT",
            };
        });
        form.post(route("product.update", product.id));
    } else {
        form.post(route("product.store"));
    }
}
</script>

<template>
    <AppLayout :actions="actions" title="Product add">
        <template #header>Product Add</template>

        <form @submit.prevent="submit" method="POST">
            <div class="p-4">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-start-1 col-end-5">
                        <TextInput required label="Name" v-model="form.product_name" />
                        <InputError :message="form.errors.product_name" />
                    </div>
                    <div class="col-start-5 col-end-9">
                        <TextInput label="Price" type="number" v-model="form.price" />
                        <InputError :message="form.errors.price" />
                    </div>
                    <div class="col-start-1 col-end-5">
                        <TextInput label="Stock qty" type="number" v-model="form.stock_qty" />
                        <InputError :message="form.errors.stock_qty" />
                    </div>
                    <div class="col-start-5 col-end-9">
                        <Select
                            label="Category"
                            v-model="form.category_id"
                            :url="route('category.index', { sortBy: { field: 'category_name', direction: 'ASC' } })"
                            :options="[]"
                            :paginate="{ data: [] }"
                            option-label="category_name" />
                        <InputError :message="form.errors.category_id" />
                    </div>
                    <div class="col-start-1 col-end-5">
                        <Select label="Status" v-model="form.status" :options="statuses" :show-search="false" />
                        <InputError :message="form.errors.status" />
                    </div>
                    <div class="col-start-9 col-end-13 row-start-1 row-end-4">
                        <InputLabel value="Feature image" />
                        <FileUpload
                            v-model="form.image"
                            :values="product?.json?.image?.url ? [product?.json?.image?.url] : null" />
                    </div>
                    <div class="col-start-1 col-end-13">
                        <TextareaInput
                            v-model="form.description"
                            label="Description"
                            cols="30"
                            rows="10"></TextareaInput>
                        <InputError :message="form.errors.description" />
                    </div>
                </div>
            </div>
        </form>
    </AppLayout>
</template>

<style scoped></style>
