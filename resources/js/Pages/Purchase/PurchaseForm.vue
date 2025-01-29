<script setup lang="ts">
import TextInput from "@/Components/Forms/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed, onMounted, reactive, ref } from "vue";
import useAction from "@/services/action.service";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import Select from "@/Components/Forms/Select.vue";
import { Purchase, PurchaseDetail, PurchaseItem } from "@/types/models/purchase";
import Button from "@/Components/Button.vue";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import DataTable from "@/Components/Tables/DataTable.vue";
import Column from "@/Components/Tables/Column.vue";
import Action from "@/Components/Tables/Action.vue";
import { Paginate } from "@/types/paginate";
import { Customer } from "@/types/models/customer";
import axios from "axios";
import { usePaginate } from "@/services/helper.service";
import { Product } from "@/types/models/product";

const props = defineProps<{
    statuses: Array<string>;
    purchase: Purchase;
}>();

const customers = ref<Paginate<Customer> | null>(usePaginate());
const products = ref<Paginate<Product> | null>(usePaginate());

const actions = computed(() => {
    const { save, cancel, refresh } = useAction();

    save.props.onClick = submit;

    cancel.props.onClick = () => {
        router.get(route("purchase.index"));
    };

    refresh.props.onClick = () => {};

    return [save, cancel, refresh];
});

const purchase_date = ref(null);
const purchase_time = ref(null);

const form = useForm({
    customer_id: "" as string | number,
    status: "pending",
    purchase_date: "",
    products: [] as PurchaseItem[],
});

const processing = reactive({
    products: false,
});

function addItem() {
    form.products.push({
        id: null,
        product_id: null,
        qty: 1,
        sub_total: 0,
        unit_Price: 0,
    });
}

function removeItem(index: number) {
    form.products.splice(index, 1);
}

function submit() {
    form.transform((item: any) => {
        let values = {
            ...item,
            purchase_date: `${purchase_date.value} ${purchase_time.value}`,
        };

        return values;
    });

    if (props.purchase) {
        form.put(route("purchase.update", props.purchase.id));
    } else {
        form.post(route("purchase.store"));
    }
}

function getCustomers() {
    axios.get(route("customer.index")).then((res) => {
        customers.value = res.data;
    });
}

function getProducts() {
    axios.get(route("product.index")).then((res) => {
        products.value = res.data;
    });
}

onMounted(() => {
    getCustomers();
    getProducts();

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
                                :nextPageUrl="customers?.next_page_url"
                                :options="customers?.data"
                                option-label="name" />
                            <InputError :message="form.errors.customer_id" />
                        </div>
                        <div class="">
                            <div class="flex gap-4">
                                <TextInput
                                    v-model="purchase_date"
                                    label="Purchase Date"
                                    required
                                    datepicker-autohide
                                    datepicker-format="yyyy-mm-dd"
                                    datepicker-buttons
                                    datepicker-autoselect-today
                                    datepicker />
                                <TextInput
                                    type="time"
                                    label=""
                                    v-model="purchase_time"
                                    required
                                    :data-date="purchase_time"
                                    timepicker />
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
                    <Button type="button" @click="addItem" severity="primary" :icon="faPlus">Add</Button>
                </div>

                <DataTable :filter="false" :checkbox="false" :show-search="false">
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
                                        v-model="item.product_id"
                                        :options="products?.data"
                                        :id="`select-option-${index}`"
                                        :loading="processing.products"
                                        :next-page-url="products?.next_page_url"
                                        dropdown-class="absolute"
                                        option-label="product_name" />
                                </Column>
                                <Column class="py-3">
                                    <TextInput v-model="item.qty" type="number" />
                                </Column>
                                <Column class="py-3">
                                    {{ item.unit_Price }}
                                </Column>
                                <Column class="py-3">{{ item.sub_total }}</Column>
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
