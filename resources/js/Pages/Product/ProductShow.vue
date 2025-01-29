<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Product } from "@/types/models/product";
import { ColumnType } from "@/types/datatable/column";
import productService from "@/services/product.service";
import { computed, nextTick, ref, watch } from "vue";
import useAction from "@/services/action.service";
import { router, useForm } from "@inertiajs/vue3";
import Alert from "@/Components/Alert/Alert.vue";
import DataValue from "@/Components/DataValue.vue";
import Button from "@/Components/Button.vue";
import { useCropper } from "@/services/cropper.service";
import FileUpload from "@/Components/Forms/FileUpload.vue";
import { Action } from "@/types/button";
import { faUpload } from "@fortawesome/free-solid-svg-icons";
import { UploadFile } from "@/types";
import { useAlertStore } from "@/services/helper.service";

const { product } = defineProps<{
    product: Product;
}>();

const columns: ColumnType<Product>[] = productService.columns;

const actions = computed(() => {
    const { edit, remove } = useAction();

    edit.props.onClick = () => {
        router.get(route("product.edit", product.id));
    };

    remove.props.onClick = () => {
        const alert = useAlertStore();

        alert.show = true;

        alert.confirm = () => {
            useForm({
                ids: [product.id],
            }).delete(route("product.destroy"), {
                onFinish: () => {
                    alert.show = false;
                    alert.confirm = () => {};
                },
            });
        };
    };

    return [edit, remove];
});
</script>

<template>
    <AppLayout :title="product.product_name" :actions="actions">
        <template #header>Product Detail</template>

        <div class="p-4">
            <div class="flex gap-3">
                <div class="flex w-8/12 flex-col gap-4">
                    <h3 class="text-lg font-semibold">Product Information</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <template v-for="column in columns">
                            <div class="flex">
                                <span class="w-1/3">{{ column.label }}:</span>
                                <span class="font-semibold">
                                    <DataValue :column="column" :item="product" />
                                </span>
                            </div>
                        </template>
                    </div>

                    <div class="leading-6" v-html="product.description"></div>
                </div>
                <div class="w-1/3">
                    <img
                        class="rounded-md"
                        v-if="product.json?.image?.url"
                        :src="product.image_url"
                        :alt="product.product_name" />
                    <img class="w-full" v-else src="@assets/images/placeholders/placeholder.jpg" alt="" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
