<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Product } from "@/types/models/product";
import { Column } from "@/types/datatable/column";
import productService from "@/services/product.service";
import { computed, ref } from "vue";
import useAction from "@/services/action.service";
import { router, useForm } from "@inertiajs/vue3";
import Alert from "@/Components/Alert/Alert.vue";
import DataValue from "@/Components/DataValue.vue";

const props = defineProps<{
    product: Product;
}>();

const product = props.product;

const confirmed = ref(false);

const actions = computed(() => {
    const { edit, remove } = useAction();

    edit.props.onClick = () => {
        router.get(route("product.edit", product.id));
    };

    remove.props.onClick = () => {
        confirmed.value = true;
    };

    return [edit, remove];
});

const columns: Column[] = productService.columns;

function destroy() {
    useForm({
        ids: [product.id],
    }).delete(route("product.destroy"));
}
</script>

<template>
    <AppLayout :title="product.product_name" :actions="actions">
        <template #header> Product Detail </template>

        <div class="p-4">
            <h3 class="text-lg font-semibold">Product Information</h3>
            <div class="mt-4 flex gap-3">
                <div class="flex w-8/12 flex-col gap-4">
                    <template v-for="column in columns">
                        <div class="flex">
                            <span class="w-1/4">{{ column.label }}:</span>
                            <span class="">
                                <DataValue :column="column" :item="product" />
                            </span>
                        </div>

                        <div class="border border-gray-50" />
                    </template>
                    <div class="leading-6" v-html="product.description"></div>
                </div>
                <div class="w-1/3">
                    <img
                        class="w-full rounded-md"
                        v-if="product.json?.image?.url"
                        :src="product.json?.image?.url"
                        :alt="product.product_name" />
                    <img class="w-full" v-else src="@assets/images/placeholders/placeholder.jpg" alt="" />
                </div>
            </div>
        </div>

        <Alert
            @confirmed="destroy()"
            type="warning"
            title="Are you sure?"
            text="Do you want to delete this?"
            v-model:show="confirmed"
            confirm-button-type="error" />
    </AppLayout>
</template>

<style scoped></style>
