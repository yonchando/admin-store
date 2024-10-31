<script setup lang="ts">
import { ref } from "vue";

defineOptions({
    inheritAttrs: false,
});

const props = withDefaults(
    defineProps<{
        multiple?: boolean;
        values?: any;
        size?: string;
        type?: string;
    }>(),
    {
        values: [],
        size: "2MB",
        type: "jpeg, gif, png, jpg",
    },
);

const model = defineModel();

const files = ref<
    {
        name: string;
        type: string;
        size: string;
        url: string;
    }[]
>([]);

function getFiles(e: Event) {
    files.value = [];

    const target = e.target as HTMLInputElement;

    const fs: any = target.files;

    model.value = props.multiple ? fs : fs[0];

    if (fs && fs.length > 0) {
        for (const file of fs) {
            const reader = new FileReader();
            let f: any = {
                name: file.name,
                type: file.type,
                size: file.size,
            };
            reader.onload = (e) => {
                f.url = (e.target?.result as string) ?? "";
                files.value.push(f);
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>

<template>
    <div
        class="relative mt-2 flex h-full flex-col items-center justify-center rounded-md border border-gray-200 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-900">
        <p class="text-xs font-medium">Select file or drop file here</p>
        <p class="text-xs font-medium">Max size: {{ size }} <span class="text-error">*</span></p>
        <p class="text-xs font-medium">File: {{ type }} <span class="text-error">*</span></p>
        <div class="file mt-4 flex flex-wrap gap-4">
            <div
                v-if="files.length > 0"
                v-for="file of files"
                class="flex size-16 items-center justify-center rounded-md border border-gray-200">
                <img class="h-16 w-auto" v-if="file.type.startsWith('image')" :src="file.url" :alt="file.name" />
                <i v-else class="fa fa-file-pdf fa-2x"></i>
            </div>
            <div
                v-if="files.length == 0 && values?.length > 0"
                v-for="file of values"
                class="flex size-16 items-center justify-center rounded-md border border-gray-200">
                <img v-if="file" class="h-16 w-auto" :src="file" alt="File" />
            </div>
        </div>
        <input
            v-bind="$attrs"
            @change="getFiles"
            multiple
            type="file"
            class="absolute inset-0 cursor-pointer rounded-md bg-gray-700 opacity-0" />
    </div>
</template>

<style scoped></style>
