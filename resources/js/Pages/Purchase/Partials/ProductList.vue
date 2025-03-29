<script setup lang="ts">
import TextInput from "@/Components/Forms/TextInput.vue";
import { Paginate } from "@/types/paginate";
import { Product, ProductFilter } from "@/types/models/product";
import { usePaginate } from "@/services/helper.service";
import { computed, onMounted, reactive, ref } from "vue";
import { currencyFormat } from "@/number_format";
import CardPlaceholder from "@/Components/Skeleton/CardPlaceholder.vue";
import Card from "@/Components/Card/Card.vue";
import productService from "@/services/product.service";
import useAction from "@/services/action.service";
import Button from "@/Components/Button.vue";
import { PurchaseItem } from "@/types/models/purchase";

defineEmits<{
    (e: "addProduct", option: Product): void;
}>();

const props = defineProps<{
    products: PurchaseItem[];
}>()

const show = defineModel("show");

const actions = computed(() => {
    const { refresh } = useAction();
    
    refresh.props.onClick = () => {
        getProducts();
    }

    return [refresh];
});

const products = ref<Paginate<Product>>(usePaginate());

const productFilters: ProductFilter = reactive({
    page: 1,
    perPage: 15,
    search: "",
});

const loading = ref(false);

let timeout = ref<NodeJS.Timeout>();

function getProducts(): any {
    return productService.getProducts(productFilters).then((res) => {
        products.value = res.data;
    });
}

function search(e: InputEvent) {
    if (timeout.value != undefined) {
        clearTimeout(timeout.value);
    }

    const input = e.target as HTMLInputElement;
    productFilters.search = input.value;

    timeout.value = setTimeout(() => {
        getProducts();
    }, 500);
}

function loadMore() {
    productFilters.page = (productFilters.page ?? 1) + 1;
    getProducts();
}

function notShowExistProduct(product: Product): boolean {
    return !props.products.filter(p => p.product_id === product.id).length;
}
onMounted(() => {
    getProducts();
});
</script>

<template>
    <Modal v-model:show="show" title="Product Lists" max-width="5xl" :actions="actions">
        <div class="mb-4">
            <TextInput @input="search" placeholder="Search..." />
        </div>
        <div class="grid max-h-screen min-h-screen grid-cols-2 gap-6">
            <template v-if="loading">
                <CardPlaceholder />
                <CardPlaceholder />
            </template>

            <template v-else>
                <template v-if="products.meta.total">
                    <template v-for="product in products.data" :key="product.id">
                        <div class="w-full" v-if="notShowExistProduct(product)">
                            <Card class="relative !bg-white !p-0">
                                <Badge severity="primary" class="absolute right-4 top-4">
                                    {{ currencyFormat(product.price) }}
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

                                <div class="flex justify-between p-4">
                                    <h1 class="flex items-center justify-between gap-4 px-4 py-3 text-lg text-dark">
                                        {{ product.product_name }}
                                    </h1>
                                    
                                    <Button severity="secondary" @click="$emit('addProduct',product)" class="">Add to cart</Button>
                                </div>
                            </Card>
                        </div>
                    </template>
                </template>
                <div v-else>
                    <div class="flex h-10 w-full items-center text-base">Empty</div>
                </div>
            </template>
        </div>

        <div class="mt-8 text-center" v-if="!loading && products.meta.current_page < products.meta.last_page">
            <Button @click="loadMore" severity="dark">Load more</Button>
        </div>
    </Modal>
</template>

<style scoped></style>
