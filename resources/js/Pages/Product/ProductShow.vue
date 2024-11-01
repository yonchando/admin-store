<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Product } from "@/types/models/product";
import { Column } from "@/types/datatable/column";
import productService from "@/services/product.service";
import { computed, onMounted, ref } from "vue";
import useAction from "@/services/action.service";
import { router, useForm } from "@inertiajs/vue3";
import Alert from "@/Components/Alert/Alert.vue";
import DataValue from "@/Components/DataValue.vue";
import placeholder from "@assets/images/placeholders/placeholder.jpg";
import Button from "@/Components/Button.vue";

const { product } = defineProps<{
    product: Product;
}>();

const confirmed = ref(false);

const showUpload = ref(false);

const actions = computed(() => {
    const { upload, edit, remove } = useAction();

    upload.props.onClick = btnUploadClick;

    edit.props.onClick = () => {
        router.get(route("product.edit", product.id));
    };

    remove.props.onClick = () => {
        confirmed.value = true;
    };

    return [upload, edit, remove];
});

const columns: Column<Product>[] = productService.columns;

const file = ref();
const src = ref<any>();
const image = ref<any>();
const crop = ref();
const isBtnDisable = computed(() => !src.value);

const form = useForm<any>({
    file: "",
});

function btnUploadClick() {
    showUpload.value = true;
}

function selectFile(e: Event) {
    cropRemove();
    const input = e.target as HTMLInputElement;

    if (input.files && input.files.length > 0) {
        file.value = input.files[0];

        const read = new FileReader();
        read.onload = () => {
            src.value = read.result;
            cropper();

            crop.value.replace(src.value);
        };
        read.readAsDataURL(file.value);
    }
}

function cropper() {
    crop.value = new Cropper(image.value, {
        aspectRatio: 16 / 9,
        minCropBoxHeight: 720,
        minCropBoxWidth: 1280,
        dragMode: "move",
        background: false,
        rotatable: false,
        scalable: false,
        zoomable: false,
        movable: false,
        cropBoxResizable: false,
    });
}

function cropRemove() {
    if (crop.value) {
        crop.value.destroy();
    }
}

function uploadFile() {
    crop.value.getCroppedCanvas().toBlob((blob: Blob) => {
        form.file = blob;
        form.post(route("product.upload.image", product.id), {
            onFinish: () => {
                showUpload.value = false;
                src.value = null;
                router.reload({
                    only: ["product"],
                });
                cropRemove();
            },
        });
    });
}

function destroy() {
    useForm({
        ids: [product.id],
    }).delete(route("product.destroy"));
}

onMounted(() => {
    btnUploadClick();
});
</script>

<template>
    <AppLayout :title="product.product_name" :actions="actions">
        <template #header> Product Detail</template>

        <div class="p-4">
            <h3 class="text-lg font-semibold">Product Information</h3>
            <div class="mt-4 flex gap-3">
                <div class="flex w-8/12 flex-col gap-4">
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
                        class="w-3/4 rounded-md"
                        v-if="product.json?.image?.url"
                        :src="product.json?.image?.url"
                        :alt="product.product_name" />
                    <img class="w-full" v-else src="@assets/images/placeholders/placeholder.jpg" alt="" />
                </div>
            </div>
        </div>
        <Modal
            v-model:show="showUpload"
            :actions="[
                {
                    label: 'Crop',
                    component: Button,
                    props: { severity: 'primary', onClick: uploadFile, disabled: isBtnDisable },
                },
            ]"
            @close="cropRemove"
            title="Upload file">
            <div class="inline-block">
                <div v-if="form.errors.file">
                    <span>{{ form.errors.file }}</span>
                </div>
                <div class="relative">
                    <input type="file" @change="selectFile" class="absolute inset-0 opacity-0" />
                    <Button severity="info">Select file</Button>
                </div>
            </div>
            <div class="mt-4 rounded-md border border-gray-100 bg-gray-100" v-show="src">
                <img ref="image" class="block w-full max-w-full" id="cropper-content" :src="src" alt="Image cropper" />
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
