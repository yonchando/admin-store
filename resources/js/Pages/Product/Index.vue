<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import useActions from "@/actions.js";
import { computed, reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import DataListing from "@/Components/DataListing.vue";
import ProductService from "@/Services/product.service.js";

const actions = computed(() => {
    return useActions(
        {
            create: ProductService.create,
            refresh: ProductService.refresh,
        },
        {
            update: {
                disabled: selectRows.value.length !== 1
            }
        },
    );
});

const props = defineProps([
    "lang",
    "products",
    "categories",
    "statuses",
    "filters",
    "errors",
    "request",
]);

const columns = reactive(ProductService.columns);

const getColumns = computed(() => columns);

const selectRows = ref([]);

const filters = ref();

</script>

<template>
    <AppLayout
        :title="lang.products"
        :actions="actions"
        has-search
    >
        <DataListing
            :data="products.data"
            :columns="getColumns"
            v-model:selection="selectRows"
            v-model:filters="filters"
            @row-dblclick="(e) => router.get(route('product.show',e.data.slug))"
        />
    </AppLayout>
</template>