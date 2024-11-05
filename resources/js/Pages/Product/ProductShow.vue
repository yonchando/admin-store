<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Product } from "@/types/models/product";
import { Column } from "@/types/datatable/column";
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

const { product } = defineProps<{
    product: Product;
}>();

const confirmed = ref(false);

const showUpload = ref(false);

const actions = computed(() => {
    const { upload, edit, remove } = useAction();

    upload.props.onClick = () => (showUpload.value = true);

    edit.props.onClick = () => {
        router.get(route("product.edit", product.id));
    };

    remove.props.onClick = () => {
        confirmed.value = true;
    };

    return [upload, edit, remove];
});

const columns: Column<Product>[] = productService.columns;

const cropper = useCropper();
const image = ref();
const files = ref<UploadFile[]>([]);

const form = useForm<any>({
    image: "",
});

const formActionUpload = computed(() => {
    const { upload } = useAction();
    upload.props.onClick = () => {
        cropper.getBlob().then((blob) => {
            form.image = blob;

            form.post(route("product.upload.image", product.id), {
                onFinish: () => {
                    showUpload.value = false;
                    cropper.$reset();
                    form.reset();
                    router.reload({
                        only: ["product"],
                    });
                },
            });
        });
    };
    return [upload];
});

function changeFile(f: UploadFile) {
    nextTick(() => {
        cropper.createCropper(image.value);
    });
}

function destroy() {
    useForm({
        ids: [product.id],
    }).delete(route("product.destroy"));
}
</script>

<template>
    <AppLayout :title="product.product_name" :actions="actions">
        <template #header> Product Detail</template>

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
                        :src="product.json?.image?.url"
                        :alt="product.product_name" />
                    <img class="w-full" v-else src="@assets/images/placeholders/placeholder.jpg" alt="" />
                </div>
            </div>
        </div>
        <Modal v-model:show="showUpload" :actions="formActionUpload" title="Feature image upload">
            <div class="inline-block">
                <div v-if="form.errors.file">
                    <span>{{ form.errors.file }}</span>
                </div>
                <div class="relative">
                    <FileUpload v-model="form.image" @change="changeFile" v-model:files="files" />
                </div>
            </div>
            <div class="mt-4 h-auto rounded-md border border-gray-100 bg-gray-100" v-if="form.image">
                <img
                    ref="image"
                    class="block w-full max-w-full"
                    id="cropper-content"
                    :src="files[0].url"
                    alt="Image cropper" />
            </div>
        </Modal>

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
