<script setup>

import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";

import Card from "@/Components/Card/Card.vue";
import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import {inject, ref} from "vue";
import ProductFilter from "@/Pages/Product/ProductFilter.vue";
import ProductStatusText from "@/Pages/Product/ProductStatusText.vue";
import {computed} from "vue";
import Paginate from "@/Components/Paginate.vue";
import WarningButton from "@/Components/Button/WarningButton.vue";
import useActions from "@/actions.js";
import FadeIn from "@/Components/Animate/FadeIn.vue";

const {lang, products} = defineProps([
    "lang",
    "products",
    "categories",
    "statuses",
    "filters",
    "errors",
]);

let index = computed(() => {
    return products.from;
});

const isFilter = ref(false);

const swal = inject("$swal");

const selected = ref(null);

const isShowFilter = ref(false);

const actions = useActions({
    create: () => {
        router.get(route('product.create'))
    },
    filter: (e) => {
        console.log(e);
        isShowFilter.value = !isShowFilter.value;
    }
});

function destroy(product) {
    swal({
        title: lang.are_you_sure,
        text: lang.do_you_want_to_delete_this.replace(
            ":attribute",
            product.product_name
        ),
        icon: "warning",
        confirmButtonClass: "btn btn-danger",
    }).then((res) => {
        if (res.value) {
            useForm({}).delete(route("product.destroy", product));
        }
    });
}

</script>

<template>
    <Head :title="lang.products"/>

    <AppLayout :actions="actions">
        <template #breadcrumb>
            <BreadcrumbItem icon="icon-box" :title="lang.products"/>
        </template>

        <FadeIn>
            <Card v-if="isShowFilter" no-header v-if="isFilter">
                <ProductFilter
                    :errors="errors"
                    :categories="categories"
                    :statuses="statuses"
                    :filter="filters"
                />
            </Card>
        </FadeIn>

        <Card :title="lang.products">
            <Table>
                <tr>
                    <th style="width:5%">#</th>
                    <th>{{ lang.product_name }}</th>
                    <th>{{ lang.category }}</th>
                    <th>{{ lang.price }}</th>
                    <th>{{ lang.stock_quantity }}</th>
                    <th style="width:120px">{{ lang.status }}</th>
                    <th>{{ lang.action }}</th>
                </tr>

                <template v-if="products.data.length > 0">
                    <tr
                        @dblclick="router.get(route('product.show',product))"
                        @click="selected = product.id"
                        :class="{'tw-bg-gray-200': selected === product.id}"
                        v-for="(product, i) in products.data">
                        <td>{{ index + i }}</td>
                        <td colspan="2">
                            <div class="tw-flex tw-gap-2 tw-items-center">
                                <img :src="product.image_url" alt="" width="60"/>
                                {{ product.product_name }}
                            </div>
                        </td>
                        <td>{{ product.category?.category_name }}</td>
                        <td class="tw-font-medium">
                            {{ product.price_text }}
                        </td>
                        <td>
                            <span class="badge badge-pill badge-info">
                                {{ product.stock_quantity }}
                            </span>
                        </td>
                        <td>
                            <ProductStatusText :product="product"/>
                        </td>
                        <td>
                            <Dropdown>
                                <template #toggle>
                                    <DropdownToggle>
                                        <i class="icon-list2"></i>
                                    </DropdownToggle>
                                </template>

                                <DropdownLink
                                    :href="route('product.edit', product.id)"
                                >
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

            <Paginate :data="products"/>
        </Card>
    </AppLayout>
</template>

<style scoped></style>
