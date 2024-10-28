<script setup lang="ts">
import TextInput from "@/Components/Forms/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import useAction from "@/services/action.service";
import AppLayout from "@/Layouts/AppLayout.vue";
import TextareaInput from "@/Components/Forms/TextareaInput.vue";
import InputError from "@/Components/Forms/InputError.vue";
import Select from "@/Components/Forms/Select.vue";
import { Category } from "@/types/models/category";

defineProps<{
    statuses: Array<string>;
}>();

const form = useForm({
    product_name: "",
    price: "",
    stock_qty: "",
    category_id: "",
    status: "",
    description: "",
});

const actions = computed(() => {
    const { save, cancel } = useAction();

    save.props.onClick = () => {
        form.post(route("product.store"));
    };

    cancel.props.onClick = () => {
        router.get(route("product.index"));
    };

    return [save, cancel];
});
</script>

<template>
    <AppLayout :actions="actions" title="Product add">
        <template #header>Product Add</template>
        <div class="p-4">
            <div class="mb-4 grid grid-cols-3 gap-4">
                <div>
                    <TextInput required label="Name" v-model="form.product_name" />
                    <InputError :message="form.errors.product_name" />
                </div>
                <div>
                    <TextInput label="Price" type="number" v-model="form.price" />
                    <InputError :message="form.errors.price" />
                </div>
                <div>
                    <TextInput label="Stock qty" type="number" v-model="form.stock_qty" />
                    <InputError :message="form.errors.stock_qty" />
                </div>
                <div>
                    <Select
                        label="Category"
                        v-model="form.category_id"
                        :url="route('category.index', { sortBy: { field: 'category_name', direction: 'ASC' } })"
                        :options="[]"
                        :paginate="{ data: [] }"
                        :option-label="(option: Category) => option.category_name" />
                    <InputError :message="form.errors.category_id" />
                </div>
                <div>
                    <Select label="Status" v-model="form.status" :options="statuses" />
                    <InputError :message="form.errors.status" />
                </div>
            </div>
            <div>
                <TextareaInput v-model="form.description" label="Description" cols="30" rows="10"></TextareaInput>
                <InputError :message="form.errors.description" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
