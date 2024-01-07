<script setup>

defineProps({
    title: String,
    hasHeader: {
        type: Boolean,
        default: true
    },
    collapse: {
        type: Boolean,
        default: false,
    },
    reload: {
        type: Boolean,
        default: false,
    },
    remove: {
        type: Boolean,
        default: false,
    }
})
</script>

<template>
    <div class="card">
        <div v-if="hasHeader" class="card-header bg-white header-elements-inline">
            <h6 v-if="title" class="card-title">{{ title }}</h6>
            <div v-if="collapse || reload || remove" class="header-elements">
                <div class="list-icons">
                    <a v-if="collapse" class="list-icons-item" data-action="collapse"></a>
                    <a v-if="reload" class="list-icons-item" data-action="reload"></a>
                    <a v-if="remove" class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <slot/>
        </div>
    </div>
</template>

<style scoped>

</style>
