<script setup lang="ts">
import { UploadFile } from "@/types";
import { nextTick, ref } from "vue";
import { useCropper } from "@/services/cropper.service";
import Button from "@/Components/Button.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";

defineOptions({
    inheritAttrs: false,
});

const props = withDefaults(
    defineProps<{
        label?: string;
        multiple?: boolean;
        values?: any;
        size?: string;
        type?: string;
        isCropper?: boolean;
        previewContent?: HTMLElement;
    }>(),
    {
        values: [],
        size: "2MB",
        type: "jpeg, gif, png, jpg",
    },
);

const emit = defineEmits<{
    change: [file: UploadFile];
}>();

const model = defineModel();

const files = defineModel<UploadFile[] | any>("files");

const cropper = useCropper();
const showCropper = ref(false);
const image = ref();

cropper.action.disabled = false;
cropper.action.onClick = (e) => {
    cropper.getBlob().then((blob) => {
        const file = cropper.file ?? ({} as any);
        let f: UploadFile = {
            name: file.name,
            type: file.type,
            size: file.size,
            url: URL.createObjectURL(blob as Blob),
        };
        showCropper.value = false;
        model.value = blob;
        files.value.push(f);
    });
};

function getFiles(e: Event) {
    files.value = [];

    const target = e.target as HTMLInputElement;

    const fs: any = target.files;

    if (fs && fs.length > 0) {
        for (const file of fs) {
            const reader = new FileReader();
            let f: UploadFile = {
                name: file.name,
                type: file.type,
                size: file.size,
                url: "",
            };
            reader.onload = (e) => {
                f.url = (e.target?.result as string) ?? "";
                if (props.isCropper) {
                    image.value.src = f.url;
                    cropper.createCropper(image.value);
                    cropper.file = file;
                    showCropper.value = true;
                } else {
                    files.value?.push(f);
                    model.value = props.multiple ? fs : fs[0];
                }

                emit("change", f);
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>

<template>
    <div class="flex flex-col gap-2">
        <InputLabel v-if="label" :value="label" for="file" />
        <input
            v-bind="$attrs"
            @change="getFiles"
            :multiple="multiple"
            class="mb-5 block w-full cursor-pointer rounded border border-gray-300 bg-gray-50 text-xs text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
            id="file"
            type="file" />
    </div>

    <Modal v-model:show="showCropper" :actions="[cropper.actions()]" @close="cropper.remove" title="Upload file">
        <div class="mt-4 rounded-md border border-gray-100 bg-gray-100">
            <img ref="image" class="cropper-images block w-full max-w-full" src="" alt="Image cropper" />
        </div>
    </Modal>
</template>

<style scoped></style>
