<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import Card from "@/Components/Cards/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import ProductStatusText from "@/Pages/Product/ProductStatusText.vue";
import FlashMessage from "@/Components/Alerts/FlashMessage.vue";
import ProductOption from "@/Pages/Product/ProductOption.vue";

const props = defineProps({
    product: Object,
    lang: Object,
    groups: Array,
    options: Array,
});
const lang = props.lang;
</script>

<template>
    <Head :title="lang.product_detail" />

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem
                :href="route('product.index')"
                icon="icon-box"
                :title="lang.products"
            />
            <BreadcrumbItem icon="fa fa-box-open" :title="lang.detail" />
        </template>

        <Card no-header>
            <div class="row">
                <div class="col-6">
                    <div class="tw-space-y-3">
                        <ListItem
                            :label="lang.product_name"
                            :value="product.product_name"
                        />
                        <ListItem
                            :label="lang.category"
                            :value="product.category?.category_name"
                        />
                        <ListItem
                            :label="lang.price"
                            :value="
                                product.price +
                                ' ' +
                                $page.props.setting?.currency?.code
                            "
                        />
                        <ListItem :label="lang.stock_quantity">
                            <span
                                class="badge badge-info badge-pill"
                                v-text="product.stock_quantity"
                            ></span>
                        </ListItem>
                        <ListItem :label="lang.status">
                            <ProductStatusText :product="product" />
                        </ListItem>
                        <div class="">
                            <div class="tw-mb-4">{{ lang.description }}</div>
                            <div v-html="product.description"></div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <img class="tw-w-2/5" :src="product.image_url" alt="" />
                </div>
            </div>
        </Card>

        <FlashMessage />

        <ProductOption
            :lang="lang"
            :product="product"
            :groups="groups"
            :options="options"
        />
    </AppLayout>
</template>

<style scoped></style>
