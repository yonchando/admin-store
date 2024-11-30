<script setup lang="ts">
import TextInput from "@/Components/Forms/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";
import useAction from "@/services/action.service";
import AppLayout from "@/Layouts/AppLayout.vue";
import TextareaInput from "@/Components/Forms/TextareaInput.vue";
import InputError from "@/Components/Forms/InputError.vue";
import Select from "@/Components/Forms/Select.vue";
import { Product } from "@/types/models/product";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import FileUpload from "@/Components/Forms/FileUpload.vue";
import { UploadFile } from "@/types";
import { Paginate } from "@/types/paginate";
import { Category } from "@/types/models/category";
import axios from "axios";

const props = defineProps<{
    statuses: Array<string>;
    product?: Product;
}>();

const imagePreview = ref();
const files = ref<UploadFile[]>([]);

const product = props.product;

const form = useForm({
    product_name: product?.product_name ?? "",
    price: product?.price ?? "",
    stock_qty: product?.stock_qty ?? "",
    category_id: product?.category_id ?? "",
    status: product?.status ?? "active",
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

const categories = ref<Paginate<Category>>();

function getCategories() {
    axios.get(route("category.index")).then((res) => {
        categories.value = res.data;
    });
}

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

onMounted(() => getCategories());
</script>

<template>
    <AppLayout :actions="actions" title="Product add">
        <template #header>Product Add</template>

        <form @submit.prevent="submit" method="POST">
            <div class="p-4">
                <div class="flex gap-4">
                    <div class="grid w-full grid-cols-2 gap-4">
                        <div class="">
                            <TextInput required label="Name" v-model="form.product_name" />
                            <InputError :message="form.errors.product_name" />
                        </div>
                        <div class="">
                            <TextInput required label="Price" type="number" v-model="form.price" />
                            <InputError :message="form.errors.price" />
                        </div>
                        <div class="">
                            <TextInput label="Stock qty" type="number" v-model="form.stock_qty" />
                            <InputError :message="form.errors.stock_qty" />
                        </div>
                        <div class="">
                            <Select
                                label="Category"
                                v-model="form.category_id"
                                :options="categories?.data"
                                :paginate="categories"
                                option-label="category_name" />
                            <InputError :message="form.errors.category_id" />
                        </div>
                        <div class="">
                            <Select label="Status" v-model="form.status" :options="statuses" :show-search="false" />
                            <InputError :message="form.errors.status" />
                        </div>
                        <div class="">
                            <FileUpload
                                label="Feature image"
                                class="mt-auto"
                                v-model="form.image"
                                v-model:files="files"
                                is-cropper
                                :previewContent="imagePreview"
                                :values="product?.json?.image?.url ? [product?.json?.image?.url] : null" />
                        </div>
                    </div>
                    <div class="flex w-1/4 flex-col">
                        <template v-if="form.image || product?.json?.image?.url">
                            <InputLabel value="Preview image" />
                            <div class="mt-2 w-full rounded-md dark:bg-gray-900">
                                <img
                                    ref="imagePreview"
                                    class="rounded-md"
                                    :src="files[0]?.url ?? product?.json?.image?.url"
                                    alt="Product image" />
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mt-4">
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
