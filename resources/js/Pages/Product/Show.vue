<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Card from "@/Components/Card/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import ProductStatusText from "@/Pages/Product/ProductStatusText.vue";
import Table from "@/Components/Table/Table.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import {computed, onMounted} from "vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InfoButton from "@/Components/Button/InfoButton.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import FlashMessage from "@/Components/Alert/FlashMessage.vue";
import InputError from "@/Components/Form/InputError.vue";

const props = defineProps({
    product: Object,
    lang: Object,
    groups: Array,
    options: Array,
});

const lang = props.lang;

const form = useForm({
    product_options: [],
});

onMounted(() => {
    $(".product-options .nav li:first-child a").tab('show');
});

function addGroup() {
    form.product_options.push({
        product_option_group_id: null,
        options: [{
            product_option_id: null, price_adjustment: null
        }],
    });

    setTimeout(() => {
        $(".product-options .nav li:last-child a").tab('show');
    }, 1)
}

const groupName = (group) => {
    const item = props.groups.find((value) => value.id === group.product_option_group_id);

    if (!item) {
        return "New Group";
    }
    return item.name;
};

function save() {
    form.post(route('product.store.product.option', props.product), {
        onSuccess: () => {
            setTimeout(() => {
                const tab = $(".product-options .nav li.nav-item:last-child a.nav-link");
                tab.tab('show');
            }, 1)
            form.reset()
        },
        preserveScroll: true,
    });

}
</script>

<template>
    <Head :title="lang.product_detail"/>

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem :href="route('product.index')" icon="icon-box" :title="lang.products"/>
            <BreadcrumbItem icon="fa fa-box-open" :title="lang.detail"/>
        </template>

        <Card no-header>
            <div class="row">
                <div class="col-6">
                    <div class="tw-space-y-3">
                        <ListItem :label="lang.product_name" :value="product.product_name"/>
                        <ListItem :label="lang.category" :value="product.category?.category_name"/>
                        <ListItem :label="lang.price"
                                  :value="product.price + ' ' +  $page.props.setting?.currency?.code "/>
                        <ListItem :label="lang.stock_quantity">
                            <span class="badge badge-info badge-pill"
                                  v-text="product.stock_quantity"></span>
                        </ListItem>
                        <ListItem :label="lang.status">
                            <ProductStatusText :product="product"/>
                        </ListItem>
                        <div class="">
                            <div class="tw-mb-4">{{ lang.description }}</div>
                            <div v-html="product.description"></div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <img class="tw-w-2/5" :src="product.image_url" alt="">
                </div>
            </div>
        </Card>

        <FlashMessage/>

        <Card :title="lang.product_options" class="product-options">

            <InfoButton @click="addGroup" class="tw-mb-3">
                <i class="icon-plus2"></i>
                {{ lang.add_group }}
            </InfoButton>

            <ul class="nav nav-tabs nav-tabs-bottom">
                <template v-for="(group,i) in product.product_has_option_groups">
                    <li class="nav-item">
                        <a :href="`#tab-${group.id}`"
                           class="nav-link"
                           role="tab"
                           data-toggle="tab">{{ group.product_option_group.name }}</a>
                    </li>
                </template>
                <template v-for="(group,i) in form.product_options">
                    <li class="nav-item">
                        <a class="nav-link" :href="`#tab-add-${i}`"
                           role="tab"
                           data-toggle="tab">
                            {{ groupName(group) }}
                            <i v-if="form.errors[`product_options.${i}.product_option_group_id`]"
                               class="fa fa-exclamation tw-ml-2 text-danger tw-text-xs"></i>
                        </a>
                    </li>
                </template>
            </ul>
            <div class="tab-content">
                <template v-for="(group,i) in product.product_has_option_groups">
                    <div class="tab-pane fade"
                         :class="{
                            'show active': i === 0
                           }"
                         :id="`tab-${group.id}`">
                        <Table>
                            <tr>
                                <th>{{ lang.name }}</th>
                                <th>{{ lang.price_adjustment }}</th>
                                <th>{{ lang.action }}</th>
                            </tr>

                            <template v-for="option in group.product_has_options">
                                <tr>
                                    <td class="text-capitalize">{{ option.product_option.name }}</td>
                                    <td>{{ option.price_adjustment_text }}</td>
                                    <td></td>
                                </tr>
                            </template>
                        </Table>
                    </div>
                </template>

                <template v-for="(group,i) in form.product_options">
                    <div class="tab-pane fade"
                         :id="`tab-add-${i}`">

                        <div class="row mb-3">
                            <div class="col-4">
                                <InputLabel :value="lang.product_option_group"/>
                                <SelectInput :items="groups" text="name" v-model="group.product_option_group_id"/>
                                <InputError :message="form.errors[`product_options.${i}.product_option_group_id`]"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group tw-grid tw-grid-cols-2 tw-gap-4">
                                    <template v-for="(option,j) in group.options">
                                        <div class="">
                                            <InputLabel :value="lang.options"/>
                                            <SelectInput v-model="option.product_option_id"
                                                         text="name"
                                                         :items="options"/>
                                            <InputError
                                                :message="form.errors[`product_options.${i}.options.${j}.product_option_id`]"/>
                                        </div>
                                        <div class="">
                                            <InputLabel :value="lang.price_adjustment"/>
                                            <TextInput v-model="option.price_adjustment"/>
                                            <InputError
                                                :message="form.errors[`product_options.${i}.options.${j}.price_adjustment`]"/>
                                        </div>
                                    </template>
                                </div>
                                <InfoButton
                                    @click="group.options.push({product_option_id: null,price_adjustment: null})">
                                    {{ lang.add_option }}
                                </InfoButton>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <template #footer v-if="form.product_options.length > 0">
                <PrimaryButton @click="save()" :disabled="form.processing">
                    <i class="icon-floppy-disk"></i>
                    <span>{{ lang.save }}</span>
                </PrimaryButton>
            </template>
        </Card>
    </AppLayout>
</template>

<style scoped>

</style>