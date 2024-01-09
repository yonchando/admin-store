<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Table from "@/Components/Table/Table.vue";
import Card from "@/Components/Card/Card.vue";
import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import {inject} from "vue";

const {lang, products} = defineProps(['lang', 'products', 'swal']);

let index = products.from;

const swal = inject('$swal');

swal({
    title: "Are you sure",
    text: "Do you want to delete this",
    icon: 'warning',
    confirmButtonClass: 'btn btn-primary',
    cancelButtonClass: 'btn btn-light',
}, {})

const destroy = (product) => {
    index = products.from;


    // swal.fire({
    //     title: 'Are you sure',
    //     text: 'Do you want to delete this?',
    //     icon: 'warning',
    //     confirmButtonClass: '',
    // }).then(
    //     res => {
    //         console.log(res);
    //         // if (res.value) {
    //         //     useForm({}).delete(route('product.destroy', product));
    //         // }
    //     }
    // )
}

</script>

<template>
    <Head :title="lang.products"/>

    <AppLayout>
        <template #action>
            <PrimaryButton :href="route('product.create')">
                <i class="icon-plus2"></i>
                {{ lang.add }}
            </PrimaryButton>
        </template>

        <template #breadcrumb>
            <BreadcrumbItem icon="icon-box" :title="lang.products"/>
        </template>

        <Card :title="lang.products">
            <Table>
                <tr>
                    <th width="50">#</th>
                    <th width="100">Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>

                <template v-if="products.data.length > 0">
                    <tr v-for="product in products.data">
                        <td>{{ index++ }}</td>
                        <td>
                            <img :src="product.image_url" alt="" width="60">
                        </td>
                        <td>{{ product.product_name }}</td>
                        <td>{{ product.category?.category_name }}</td>
                        <td>${{ product.price }}</td>
                        <td>
                            <Dropdown>
                                <template #toggle>
                                    <DropdownToggle>
                                        <i class="icon-list2"></i>
                                    </DropdownToggle>
                                </template>

                                <DropdownLink :href="route('product.edit',product)">
                                    <i class="icon-pencil7"></i>
                                    {{ lang.edit }}
                                </DropdownLink>

                                <DropdownLink @click="destroy(product)">
                                    <i class="icon-trash-alt"></i>
                                    {{ lang.delete }}
                                </DropdownLink>
                            </Dropdown>
                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td colspan="6">{{ lang.empty }}</td>
                    </tr>
                </template>

            </Table>
        </Card>

    </AppLayout>
</template>

<style scoped>

</style>
