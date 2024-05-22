<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import Card from "@/Components/Cards/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import Table from "@/Components/Tables/Table.vue";

import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import { inject } from "vue";
import FlashMessage from "@/Components/Alerts/FlashMessage.vue";

const { lang, purchase, status } = defineProps({
    purchase: Object,
    lang: Object,
    status: Object,
});

const swal = inject("$swal");

const updatePurchaseStatus = (statusUpdate) => {
    swal({
        title: lang.are_you_sure,
        text: lang.do_you_want_to.replace(
            ":attribute",
            statusUpdate.toLowerCase(),
        ),
        icon:
            statusUpdate === status.CANCELED || statusUpdate === status.REJECTED
                ? "error"
                : "warning",
        confirmButtonClass:
            statusUpdate === status.CANCELED || statusUpdate === status.REJECTED
                ? "btn btn-danger"
                : "btn btn-primary",
    }).then((res) => {
        if (res.value) {
            useForm({ status: statusUpdate }).patch(
                route("purchase.order.update.status", purchase),
            );
        }
    });
};
</script>

<template>
    <Head :title="lang.order_detail" />

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem
                :href="route('purchase.order.index')"
                icon="icon-box"
                :title="lang.purchase_orders"
            />
            <BreadcrumbItem icon="fa fa-box-open" :title="lang.detail" />
        </template>

        <template #action>
            <PrimaryButton @click="updatePurchaseStatus(status.ACCEPTED)">
                <i class="icon-check2"></i>
                {{ lang.accepted }}
            </PrimaryButton>
        </template>

        <FlashMessage />

        <Card no-header>
            <div class="row">
                <div class="col-6">
                    <div class="tw-space-y-3">
                        <ListItem
                            :label="lang.transaction_id"
                            :value="`#${purchase.transaction_id}`"
                        />
                        <ListItem
                            :label="lang.customer"
                            :value="purchase.customer.name"
                        />
                        <ListItem
                            :label="lang.total_price"
                            :value="`${purchase.total_price} ${$page.props.setting?.currency?.code}`"
                        />
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

                <tr
                    v-for="(product, i) in purchase.order_items"
                    :key="product.id"
                >
                    <td>{{ i + 1 }}</td>
                    <td>{{ product.product_name }}</td>
                    <td>
                        {{ product.product_price }}
                        {{ $page.props.setting?.currency?.code }}
                    </td>
                    <td>{{ product.qty }}</td>
                    <td>
                        {{ product.total_price }}
                        {{ $page.props.setting?.currency?.code }}
                    </td>
                </tr>

                <tr class="tw-font-medium">
                    <td class="text-right" colspan="4">{{ lang.total }}</td>
                    <td>
                        {{ purchase.total_price }}
                        {{ $page.props.setting?.currency?.code }}
                    </td>
                </tr>
            </Table>
        </Card>
    </AppLayout>
</template>

<style scoped></style>
