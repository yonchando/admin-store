<script setup>
import CkeditorService from "@/Services/ckeditor.service.js";

const editor = CkeditorService.editor;

const config = CkeditorService.config;

const model = defineModel();
</script>

<template>
    <ckeditor :editor="editor" v-model="model" :config="config" />
</template>

<style>
.ck-content {
    height: 320px;
}

.ck-content > blockquote,
.ck-content > dl,
.ck-content > dd,
.ck-content > h1,
.ck-content > h2,
.ck-content > h3,
.ck-content > h4,
.ck-content > h5,
.ck-content > h6,
.ck-content > hr,
.ck-content > figure,
.ck-content > p,
.ck-content > pre {
    margin: revert;
}

.ck-content > ol,
.ck-content > ul {
    list-style: revert;
    margin: revert;
    padding: revert;
}

.ck-content > table {
    border-collapse: revert;
}

.ck-content > h1,
.ck-content > h2,
.ck-content > h3,
.ck-content > h4,
.ck-content > h5,
.ck-content > h6 {
    font-size: revert;
    font-weight: revert;
}
</style>
