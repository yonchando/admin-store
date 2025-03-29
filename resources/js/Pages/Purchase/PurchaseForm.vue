<script setup lang="ts">
import { router, useForm } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";
import useAction from "@/services/action.service";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import Select from "@/Components/Forms/Select.vue";
import { Purchase, PurchaseDetail, PurchaseItem } from "@/types/models/purchase";
import Button from "@/Components/Button.vue";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import DataTable from "@/Components/Tables/DataTable.vue";
import Column from "@/Components/Tables/Column.vue";
import { Paginate } from "@/types/paginate";
import { Customer } from "@/types/models/customer";
import axios from "axios";
import { usePaginate } from "@/services/helper.service";
import ProductList from "@/Pages/Purchase/Partials/ProductList.vue";
import Datepicker from "@/Components/Forms/Datepicker.vue";
import dayjs from "@/dayjs";
import { Product } from "@/types/models/product";
import TextInput from "@/Components/Forms/TextInput.vue";
import _ from "lodash";
import { currencyFormat } from "@/number_format";

const props = defineProps<{
    statuses: Array<string>;
    purchase: Purchase;
}>();

const showProductList = ref(false);

const customers = ref<Paginate<Customer>>(usePaginate());

const actions = computed(() => {
    const { save, cancel, refresh } = useAction();

    save.props.onClick = submit;

    cancel.props.onClick = () => {
        router.get(route("purchase.index"));
    };

    refresh.props.onClick = () => {
        getCustomers();
    };

    return [save, cancel, refresh];
});

const purchase_date = ref(dayjs().format("YYYY-MM-DD"));
const purchase_time = ref(dayjs().format("h:mm A"));

const form = useForm({
    customer_id: "" as string | number,
    status: "pending",
    purchase_date: `${purchase_date.value} ${purchase_time.value}`,
    products: [] as PurchaseItem[],
});

const total = computed(() => {
    return currencyFormat(_.sumBy(form.products, (item: PurchaseItem) => item.sub_total));
});

function submit() {
    form.transform((item: any) => {
        return {
            ...item,
            purchase_date: `${purchase_date.value} ${purchase_time.value}`,
        };
    });

    if (props.purchase) {
        form.put(route("purchase.update", props.purchase.id));
    } else {
        form.post(route("purchase.store"));
    }
}

function getCustomers(page: number = 1) {
    axios
        .get(route("customer.index"), {
            params: {
                page,
            },
        })
        .then((res) => {
            customers.value.data = [...customers.value.data, ...res.data.data];
            customers.value.meta = res.data.meta;
            customers.value.links = res.data.links;
        });
}

function addProduct(product: Product) {
    form.products.push({
        product_id: product.id,
        qty: 1,
        unit_Price: Number(product.price),
        sub_total: Number(product.price),
        product: product,
    });
}

function changeQty(index: number, type: "plus" | "minus") {
    if (type === "plus") {
        form.products[index].qty++;
    } else {
        if (form.products[index].qty === 1) {
            return;
        }
        form.products[index].qty--;
    }
}

function getSubtotal(index: number, item: PurchaseItem) {
    item.sub_total = form.products[index].qty * item.unit_Price;

    return currencyFormat(item.sub_total);
}

onMounted(() => {
    getCustomers();

    if (props.purchase) {
        form.customer_id = props.purchase.customer_id;
        form.purchase_date = props.purchase.purchased_at;
        form.status = props.purchase.status;

        form.products = props.purchase.purchase_details.map((item: PurchaseDetail) => {
            return {
                id: item.id,
                product_id: item.product_id,
                qty: item.qty,
                sub_total: item.sub_total,
                unit_Price: item.price,
                product: item.product,
            };
        });
    }
});
</script>

<template>
    <AppLayout :actions="actions" title="Product add">
        <template #header>Purchase order</template>

        <form @submit.prevent="submit" method="POST">
            <div class="p-4">
                <div class="flex gap-4">
                    <div class="grid w-full grid-cols-2 gap-4">
                        <div class="">
                            <Select
                                label="Customer"
                                required
                                v-model="form.customer_id"
                                :options="customers.data"
                                :meta="customers.meta"
                                @loadMore="(page) => getCustomers(page)"
                                option-label="name" />
                            <InputError :message="form.errors.customer_id" />
                        </div>
                        <div class="">
                            <div class="flex gap-4">
                                <Datepicker label="Purchase date" v-model="purchase_date" />
                            </div>
                            <InputError :message="form.errors.purchase_date" />
                        </div>
                        <div class="">
                            <Select label="Status" v-model="form.status" :options="statuses" :show-search="false" />
                            <InputError :message="form.errors.status" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <h2 class="text-xl">Purchase Items</h2>
                    <Button type="button" @click="showProductList = true" severity="primary" :icon="faPlus">
                        Select Products
                    </Button>
                </div>

                <div class="overflow-hidden">
                    <DataTable :filter="false" :checkbox="false" :show-search="false">
                        <template #thead>
                            <tr class="group">
                                <Column class="head w-8 px-0 py-6 text-center">#</Column>
                                <Column class="head py-6">Product</Column>
                                <Column class="head w-96 py-6">Qty</Column>
                                <Column class="head w-60 py-6">Price</Column>
                                <Column class="head w-60 py-6">Sub Total</Column>
                                <Column class="head w-60 py-6">Action</Column>
                            </tr>
                        </template>

                        <template #tbody>
                            <template v-if="form.products.length">
                                <tr v-for="(item, index) in form.products" class="group">
                                    <Column class="px-0 py-3 text-center">{{ index + 1 }}</Column>
                                    <Column class="py-3">
                                        {{ item.product?.product_name }}
                                    </Column>
                                    <Column class="py-3">
                                        <div class="flex gap-4">
                                            <TextInput type="number" v-model="form.products[index].qty" />
                                            <Button
                                                type="button"
                                                severity="dark"
                                                @click="changeQty(index, 'plus')"
                                                class="!p-3">
                                                <i class="fa fa-plus"></i>
                                            </Button>
                                            <Button
                                                type="button"
                                                severity="dark"
                                                @click="changeQty(index, 'minus')"
                                                class="!p-3">
                                                <i class="fa fa-minus"></i>
                                            </Button>
                                        </div>
                                    </Column>
                                    <Column class="py-3">
                                        {{ currencyFormat(item.unit_Price) }}
                                    </Column>
                                    <Column class="py-3">{{ getSubtotal(index, item) }}</Column>
                                    <Column class="py-3 text-center">
                                        <Button
                                            type="button"
                                            severity="error"
                                            @click="form.products.splice(index, 1)"
                                            class="!p-3">
                                            <i class="fa fa-trash"></i>
                                        </Button>
                                    </Column>
                                </tr>

                                <tr>
                                    <Column colspan="4" class="py-4 pr-6 text-right">Total:</Column>
                                    <Column colspan="2" class="">{{ total }}</Column>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <Column colspan="6" class="py-3">Empty data</Column>
                                </tr>
                            </template>
                        </template>
                    </DataTable>
                </div>
            </div>
        </form>

        <ProductList v-model:show="showProductList" @add-product="addProduct" :products="form.products" />
    </AppLayout>
</template>

<style scoped></style>
