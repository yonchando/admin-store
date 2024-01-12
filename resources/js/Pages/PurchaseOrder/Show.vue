<script setup>

import {Head} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Card from "@/Components/Card/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import Table from "@/Components/Table/Table.vue";

const {lang} = defineProps({
    purchase: Object,
    lang: Object
})

</script>

<template>
    <Head :title="lang.order_detail"/>

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem :href="route('purchase.order.index')" icon="icon-box" :title="lang.purchase_orders"/>
            <BreadcrumbItem icon="fa fa-box-open" :title="lang.detail"/>
        </template>

        <Card :has-header="false">
            <div class="row">
                <div class="col-6">
                    <div class="tw-space-y-3">
                        <ListItem :label="lang.transaction_id" :value="`#${purchase.transaction_id}`"/>
                        <ListItem :label="lang.customer" :value="purchase.customer.name"/>
                        <ListItem :label="lang.total_price" :value="`$${purchase.tota_price}`"/>
                        <ListItem :label="lang.status">
                            <div v-html="purchase.status_text"></div>
                        </ListItem>
                    </div>
                </div>
            </div>
        </Card>

        <Card :title="lang.purchase_items">
            <Table>
                <tr>
                    <th>#</th>
                    <th>{{ lang.product_name }}</th>
                    <th>{{ lang.price }}</th>
                    <th>{{ lang.qty }}</th>
                    <th>{{ lang.total_price }}</th>
                </tr>

                <tr v-for="(product,i) in purchase.order_items" :key="product.id">
                    <td>{{ i + 1 }}</td>
                    <td>{{ product.product_name }}</td>
                    <td>{{ product.product_price }} USD</td>
                    <td>{{ product.qty }}</td>
                    <td>{{ product.total_price }} USD</td>
                </tr>

                <tr class="tw-font-medium">
                    <td class="text-right" colspan="4">{{ lang.total }}</td>
                    <td>{{ purchase.total_price }} USD</td>
                </tr>
            </Table>
        </Card>
    </AppLayout>
</template>

<style scoped>

</style>