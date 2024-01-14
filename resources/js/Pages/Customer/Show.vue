<script setup>
import {Link} from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Card from "@/Components/Card/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import Table from "@/Components/Table/Table.vue";

const {lang} = defineProps({
    customer: Object,
    lang: Object
})

</script>

<template>
    <Head :title="lang.customer_detail"/>

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem :href="route('customer.index')" icon="icon-box" :title="lang.customer_detail"/>
            <BreadcrumbItem icon="fa fa-box-open" :title="lang.detail"/>
        </template>

        <Card no-header>
            <div class="row">
                <div class="col-6">
                    <div class="tw-space-y-3">
                        <ListItem :label="lang.name" :value="customer.name"/>
                        <ListItem :label="lang.name" :value="customer.name"/>
                        <ListItem :label="lang.email" :value="customer.email"/>
                        <ListItem :label="lang.gender" :value="customer.gender_text"/>
                        <ListItem :label="lang.total_purchase" :value="customer.purchase_orders_count"/>
                    </div>
                </div>
            </div>
        </Card>

        <Card :title="lang.purchase_orders">
            <Table>
                <tr>
                    <th>#</th>
                    <th>{{ lang.transaction_id }}</th>
                    <th>{{ lang.total_price }}</th>
                    <th>{{ lang.total_items }}</th>
                    <th>{{ lang.purchased_date }}</th>
                    <th>{{ lang.status }}</th>
                </tr>

                <template v-if="customer.purchase_orders.length > 0">
                    <tr v-for="(purchase,i) in customer.purchase_orders" :key="purchase.id">
                        <td>{{ i + 1 }}</td>
                        <td>
                            <Link :href="route('purchase.order.show',purchase)">
                                #{{ purchase.transaction_id }}
                            </Link>
                        </td>
                        <td>{{ purchase.total_price }} USD</td>
                        <td>{{ purchase.order_items_count }}</td>
                        <td>{{ purchase.purchased_date }} USD</td>
                        <td v-html="purchase.status_text"></td>
                    </tr>
                </template>

            </Table>
        </Card>
    </AppLayout>
</template>

<style scoped>

</style>