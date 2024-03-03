<script setup>
import {Link, Head, usePage, router} from "@inertiajs/vue3";

import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Card from "@/Components/Card/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import NavTab from "@/Components/NavTab/NavTab.vue";
import NavItem from "@/Components/NavTab/NavItem.vue";
import NavPane from "@/Components/NavTab/NavPane.vue";
import UserPurchase from "@/Pages/Customer/UserPurchase.vue";
import UserCard from "@/Pages/Customer/UserCard.vue";

const props = defineProps({
    customer: Object,
})

const lang = usePage().props.lang;

</script>

<template>

    <Head :title="lang.detail"/>

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

        <Card>
            <NavTab>
                <template #tabs>
                    <NavItem target="#purchase">
                        {{ lang.purchase_orders }}
                    </NavItem>
                    <NavItem target="#cards" active>
                        Card
                    </NavItem>
                </template>

                <NavPane id="purchase" class="">
                    <UserPurchase :data="customer.purchase_orders"/>
                </NavPane>

                <NavPane id="cards" class="show active">
                    <UserCard :customer="customer"/>
                </NavPane>
            </NavTab>
        </Card>
    </AppLayout>
</template>

<style scoped>

</style>
