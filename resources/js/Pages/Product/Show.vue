<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Card from "@/Components/Card/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import ProductStatusText from "@/Pages/Product/ProductStatusText.vue";
import Table from "@/Components/Table/Table.vue";

const {lang} = defineProps({
    product: Object,
    lang: Object
})

</script>

<template>
    <Head :title="lang.product_detail"/>

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem :href="route('product.index')" icon="icon-box" :title="lang.products"/>
            <BreadcrumbItem icon="fa fa-box-open" :title="lang.detail"/>
        </template>

        <Card no-header>
            <div class="row">
                <div class="col-6">
                    <div class="tw-space-y-3">
                        <ListItem :label="lang.product_name" :value="product.product_name"/>
                        <ListItem :label="lang.category" :value="product.category?.category_name"/>
                        <ListItem :label="lang.price"
                                  :value="product.price + ' ' +  $page.props.setting?.currency?.code "/>
                        <ListItem :label="lang.stock_quantity">
                            <span class="badge badge-info badge-pill"
                                  v-text="product.stock_quantity"></span>
                        </ListItem>
                        <ListItem :label="lang.status">
                            <ProductStatusText :product="product"/>
                        </ListItem>
                        <div class="">
                            <div class="tw-mb-4">{{ lang.description }}</div>
                            <div v-html="product.description"></div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <img class="tw-w-2/5" :src="product.image_url" alt="">
                </div>
            </div>
        </Card>

        <Card :title="lang.product_options">
            <ul class="nav nav-tabs nav-tabs-bottom">
                <template v-for="(group,i) in product.product_has_option_groups">
                    <li class="nav-item">
                        <a :href="`#tab-${group.id}`" class="nav-link"
                           :class="{
                            'active': i === 0
                           }"
                           data-toggle="tab">{{ group.product_option_group.name }}</a>
                    </li>
                </template>
            </ul>
            <div class="tab-content">
                <template v-for="(group,i) in product.product_has_option_groups">
                    <div class="tab-pane fade"
                         :class="{
                            'show active': i === 0
                           }"
                         :id="`tab-${group.id}`">
                        <Table>
                            <tr>
                                <th>{{ lang.name }}</th>
                                <th>{{ lang.price_adjustment }}</th>
                                <th>{{ lang.action }}</th>
                            </tr>

                            <template v-for="option in group.product_has_options">
                                <tr>
                                    <td class="text-capitalize">{{ option.product_option.name }}</td>
                                    <td>{{ option.price_adjustment_text }}</td>
                                    <td></td>
                                </tr>
                            </template>
                        </Table>
                    </div>
                </template>
            </div>

        </Card>
    </AppLayout>
</template>

<style scoped>

</style>