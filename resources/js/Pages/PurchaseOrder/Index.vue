<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card/Card.vue";
import Table from "@/Components/Table/Table.vue";
import Action from "@/Components/Button/Action.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import {Link} from "@inertiajs/vue3";
import {inject} from "vue";

const {lang, purchaseOrders, status} = defineProps(['lang', 'purchaseOrders', 'status']);

let index = purchaseOrders.from;

const swal = inject('$swal');

const updatePurchaseStatus = (purchase, statusUpdate) => {
    index = purchaseOrders.from;

    swal({
        title: lang.are_you_sure,
        text: lang.do_you_want_to.replace(':attribute', statusUpdate.toLowerCase()),
        icon: statusUpdate === status.CANCELED || statusUpdate === status.REJECTED ? 'error' : 'warning',
        confirmButtonClass: statusUpdate === status.CANCELED || statusUpdate === status.REJECTED ? 'btn btn-danger' : 'btn btn-primary',
    }).then(
        res => {
            if (res.value) {
                useForm({status: statusUpdate})
                    .patch(route('purchase.order.update.status', purchase));
            }
        }
    )
}

</script>

<template>
    <Head :title="lang.purchase_orders"/>

    <AppLayout>
        <Card :title="lang.purchase_orders">
            <Table>
                <tr>
                    <th>{{ lang['n.o'] }}</th>
                    <th>{{ lang.transaction_id }}</th>
                    <th>{{ lang.customer }}</th>
                    <th>{{ lang.total_price }}</th>
                    <th>{{ lang.total_items }}</th>
                    <th>{{ lang.purchased_date }}</th>
                    <th>{{ lang.status }}</th>
                    <th>{{ lang.action }}</th>
                </tr>

                <template v-if="purchaseOrders.data.length > 0">
                    <tr v-for="purchase in purchaseOrders.data">
                        <td>{{ index++ }}</td>
                        <td>
                            <Link :href="route('purchase.order.show',purchase)">
                                #{{ purchase.transaction_id }}
                            </Link>
                        </td>
                        <td v-text=" purchase.customer.name "></td>
                        <td class="tw-font-medium"
                            v-text="`${purchase.total_price} ${ $page.props.setting?.currency?.code }`"></td>
                        <td v-text=" purchase.order_items_count "></td>
                        <td v-text=" purchase.purchased_date "></td>
                        <td v-html="purchase.status_text"></td>
                        <td>
                            <template v-if="purchase.status === status.PENDING || purchase.status === status.ACCEPTED">
                                <Action>
                                    <DropdownLink v-if="purchase.status === status.PENDING"
                                                  @click="updatePurchaseStatus(purchase,status.ACCEPTED)">
                                        <i class="icon-check2 text-success"></i>
                                        {{ status.ACCEPTED }}
                                    </DropdownLink>
                                    <template v-if="purchase.status === status.ACCEPTED">
                                        <DropdownLink @click="updatePurchaseStatus(purchase, status.SHIPPED)">
                                            <i class="icon-box-add text-info"></i>
                                            {{ status.SHIPPED }}
                                        </DropdownLink>
                                        <DropdownLink @click="updatePurchaseStatus(purchase, status.CANCELED)">
                                            <i class="icon-x text-danger"></i>
                                            {{ status.CANCELED }}
                                        </DropdownLink>
                                    </template>
                                    <DropdownLink v-if="purchase.status === status.PENDING"
                                                  @click="updatePurchaseStatus(purchase,'REJECTED')">
                                        <i class="icon-x text-danger"></i>
                                        {{ status.REJECTED }}
                                    </DropdownLink>
                                </Action>
                            </template>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td colspan="8">{{ lang.empty }}</td>
                    </tr>
                </template>

            </Table>
        </Card>
    </AppLayout>
</template>

<style scoped>

</style>