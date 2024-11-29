<script setup lang="ts">
import TextInput from "@/Components/Forms/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed, onMounted } from "vue";
import useAction from "@/services/action.service";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import Select from "@/Components/Forms/Select.vue";
import { Purchase, PurchaseDetail, PurchaseItem } from "@/types/models/purchase";
import Button from "@/Components/Button.vue";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import { useCustomerStore } from "@/services/customer.service";
import DataTable from "@/Components/Tables/DataTable.vue";
import { useProductStore } from "@/services/product.service";
import Column from "@/Components/Tables/Column.vue";
import Action from "@/Components/Tables/Action.vue";
import { currency } from "@/number_format";

const props = defineProps<{
    statuses: Array<string>;
    purchase: Purchase;
}>();

const customerStore = useCustomerStore();
const productStore = useProductStore();

const actions = computed(() => {
    const { save, cancel, refresh } = useAction();

    save.props.onClick = submit;

    cancel.props.onClick = () => {
        router.get(route("purchase.index"));
    };

    refresh.props.onClick = () => {
        customerStore.getData();
        productStore.getData();
    };

    return [save, cancel, refresh];
});

const form = useForm({
    customer_id: "" as string | number,
    status: "pending",
    purchase_date: "",
    products: [] as PurchaseItem[],
});

function addItem() {
    form.products.push({
        id: null,
        product_id: null,
        qty: 1,
        sub_total: 0,
    });
}

function removeItem(index: number) {
    form.products.splice(index, 1);
}

function price(item: PurchaseItem) {
    const product = productStore.data.find((value) => item.product_id === value.id);

    return currency(product?.price ?? 0);
}

function subTotal(item: PurchaseItem) {
    const product = productStore.data.find((value) => item.product_id === value.id);

    return currency((product?.price ?? 0) * item.qty);
}

function submit() {
    if (props.purchase) {
        form.put(route("purchase.update", props.purchase.id));
    } else {
        form.post(route("purchase.store"));
    }
}

onMounted(() => {
    if (props.purchase) {
        productStore.getData();

        form.customer_id = props.purchase.customer_id;
        form.purchase_date = props.purchase.purchased_at.replace(" | ", " ");
        form.status = props.purchase.status;

        form.products = props.purchase.purchase_details.map((item: PurchaseDetail) => {
            return {
                id: item.id,
                product_id: item.product_id,
                qty: item.qty,
                sub_total: item.sub_total,
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
                                @open="customerStore.getData()"
                                @search="customerStore.search"
                                @more="customerStore.more"
                                required
                                v-model="form.customer_id"
                                v-model:loading="customerStore.loading"
                                :has-more-page="customerStore.isLastPage()"
                                :options="customerStore.data"
                                option-label="name" />
                            <InputError :message="form.errors.customer_id" />
                        </div>
                        <div class="">
                            <TextInput label="Purchase Date" v-model="form.purchase_date" required />
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
                    <Button type="button" @click="addItem" severity="primary" :icon="faPlus">Add</Button>
                </div>

                <DataTable :filter="false" :checkbox="false">
                    <template #thead>
                        <tr>
                            <Column class="head w-8 px-0 py-3 text-center">#</Column>
                            <Column class="head py-3">Product</Column>
                            <Column class="head py-3">Qty</Column>
                            <Column class="head py-3">Price</Column>
                            <Column class="head w-32 py-3">Sub Total</Column>
                            <Column class="head w-32 py-3">Action</Column>
                        </tr>
                    </template>

                    <template #tbody>
                        <template v-if="form.products.length">
                            <tr v-for="(item, index) in form.products">
                                <Column class="px-0 py-3 text-center">{{ index + 1 }}</Column>
                                <Column class="py-3">
                                    <Select
                                        @open="productStore.getData()"
                                        @search="(search) => productStore.search({ search })"
                                        v-model="item.product_id"
                                        :options="productStore.data"
                                        option-label="product_name" />
                                </Column>
                                <Column class="py-3">
                                    <TextInput v-model="item.qty" type="number" />
                                </Column>
                                <Column class="py-3">
                                    {{ price(item) }}
                                </Column>
                                <Column class="py-3">{{ subTotal(item) }}</Column>
                                <Column class="py-3">
                                    <Action :destroy="() => removeItem(index)" />
                                </Column>
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
        </form>
    </AppLayout>
</template>

<style scoped></style>
