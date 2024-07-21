<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Table from "@/Components/Table/Table.vue";
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

const swal = inject("$swal");

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
    <Head :title="lang.products" />

    <AppLayout :actions="actions">
        <template #breadcrumb>
            <BreadcrumbItem icon="icon-box" :title="lang.products" />
        </template>

        <FadeIn>
            <Card v-if="isShowFilter" no-header>
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
                    <th width="50">#</th>
                    <th width="100">{{ lang.image }}</th>
                    <th>{{ lang.product_name }}</th>
                    <th>{{ lang.category }}</th>
                    <th>{{ lang.price }}</th>
                    <th>{{ lang.stock_quantity }}</th>
                    <th width="120">{{ lang.status }}</th>
                    <th>{{ lang.action }}</th>
                </tr>

                <template v-if="products.data.length > 0">
                    <tr v-for="(product, i) in products.data">
                        <td>{{ index + i }}</td>
                        <td>
                            <img :src="product.image_url" alt="" width="60" />
                        </td>
                        <td>
                            <Link :href="route('product.show', product)">
                                {{ product.product_name }}
                            </Link>
                        </td>
                        <td>{{ product.category?.category_name }}</td>
                        <td class="tw-font-medium">
                            {{ product.price }}
                            {{ $page.props.setting?.currency?.code }}
                        </td>
                        <td>
                            <span class="badge badge-pill badge-info">{{
                                product.stock_quantity
                            }}</span>
                        </td>
                        <td>
                            <ProductStatusText :product="product" />
                        </td>
                        <td>
                            <Dropdown>
                                <template #toggle>
                                    <DropdownToggle>
                                        <i class="icon-list2"></i>
                                    </DropdownToggle>
                                </template>

                                <DropdownLink
                                    :href="route('product.edit', product)"
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

            <Paginate :data="products" />
        </Card>
    </AppLayout>
</template>

<style scoped></style>
