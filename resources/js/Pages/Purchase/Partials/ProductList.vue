<script setup lang="ts">
import TextInput from "@/Components/Forms/TextInput.vue";
import { Paginate } from "@/types/paginate";
import { Product } from "@/types/models/product";
import { usePaginate } from "@/services/helper.service";
import { onMounted, ref } from "vue";
import axios from "axios";
import { currency } from "@/number_format";
import CardPlaceholder from "@/Components/Skeleton/CardPlaceholder.vue";
import Card from "@/Components/Card/Card.vue";

const show = defineModel("show");

const products = ref<Paginate<Product>>(usePaginate());

const loading = ref(false);

const productSearch = ref<string>("");

function getProducts(page: number = 1): any {
    return new Promise((resolve) => {
        axios
            .get(route("product.index"), {
                params: {
                    page: page,
                    perPage: 20,
                    search: productSearch.value,
                },
            })
            .then((res) => {
                products.value.data = [...products.value.data, ...res.data.data];
                products.value.meta = res.data.meta;
                products.value.links = res.data.links;

                resolve(res);
            })
            .finally(() => {
                // loading.value = false;
            });
    });
}

let timeout = ref<NodeJS.Timeout>();

function search() {
    if (timeout.value != undefined) {
        clearTimeout(timeout.value);
    }

    timeout.value = setTimeout(() => {
        getProducts().then((res: any) => {
            console.log(res.data);
            products.value = res.data;
        });
    }, 500);
}

onMounted(() => {
    getProducts();
});
</script>

<template>
    <Modal v-model:show="show" title="Product Lists" max-width="5xl">
        <div class="mb-4">
            <TextInput v-model="productSearch" @input="search" placeholder="Search..." />
        </div>
        <div class="grid grid-cols-2 gap-6">
            <template v-if="loading">
                <CardPlaceholder />
                <CardPlaceholder />
            </template>
            <template v-if="!loading" v-for="product in products.data" :key="product.id">
                <Card class="relative !bg-white !p-0">
                    <Badge severity="primary" class="absolute right-4 top-4">
                        {{ currency(product.price) }}
                    </Badge>
                    <div class="flex items-center gap-4">
                        <img
                            class="w-full rounded-t-md"
                            v-if="product.image_url"
                            :src="product.image_url"
                            :alt="product.product_name"
                            onerror="this.src = '@assets/images/placeholders/placeholder.png'" />
                        <img
                            class="w-full rounded-t-md"
                            v-if="!product.image_url"
                            src="@assets/images/placeholders/placeholder.png"
                            :alt="product.product_name" />
                    </div>

                    <h1 class="flex items-center justify-between gap-4 px-4 py-3 text-lg text-dark">
                        {{ product.product_name }}
                    </h1>
                </Card>
            </template>
        </div>

        <div class="mt-8 text-center" v-if="!loading && products.meta.current_page < products.meta.last_page">
            <Button @click="getProducts(products.meta.current_page + 1)" severity="dark">Load more</Button>
        </div>
    </Modal>
</template>

<style scoped></style>
