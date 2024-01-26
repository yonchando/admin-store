<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Card from "@/Components/Card/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import ProductStatusText from "@/Pages/Product/ProductStatusText.vue";
import Table from "@/Components/Table/Table.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import {computed, inject} from "vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InfoButton from "@/Components/Button/InfoButton.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import FlashMessage from "@/Components/Alert/FlashMessage.vue";
import InputError from "@/Components/Form/InputError.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

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

let activeTabState = computed(() => {
    $(".product-options .nav li a.nav-link").tab();
    return (form.product_options.length + props.product.product_has_option_groups.length) - 1
});

function groupName(group) {
    const item = props.groups.find((value) => value.id === group.product_option_group_id);

    if (!item) {
        return "New Group";
    }
    return item.name;
}

function addGroup() {
    form.product_options.push({
        product_option_group_id: null,
        options: [{
            product_option_id: null, price_adjustment: null
        }],
    });
}

const swal = inject('$swal');

function deleteGroup(group) {
    swal({
        title: lang.are_you_sure,
        html: lang.do_you_want_to_delete_this.replace(
            ":attribute",
            group.product_option_group.name,
        ) + `<br> ${lang.cant_undo}`,
        icon: "warning",
        confirmButtonClass: "btn btn-danger",
    }).then((res) => {
        if (res.value) {
            useForm({}).delete(route("product.destroy.product.option.group", group), {
                onSuccess: () => $(".product-options a").tab('show')
            });
        }
    });
}

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
                    <li class="nav-item tw-flex tw-items-center">
                        <a :href="`#tab-${group.id}`"
                           class="nav-link tw-peer"
                           :class="{
                            active: activeTabState === i,
                           }"
                           role="tab"
                           data-toggle="tab">
                            {{ group.product_option_group.name }}
                        </a>
                    </li>
                </template>
                <template v-for="(group,i) in form.product_options">
                    <li class="nav-item">
                        <a class="nav-link" :href="`#tab-add-${i}`"
                           role="tab"
                           :class="{
                            active: activeTabState === (i + product.product_has_option_groups.length),
                           }"
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
                            'show active': i === activeTabState
                           }"
                         :id="`tab-${group.id}`">
                        <DangerButton @click="deleteGroup(group)">
                            <span v-lang:delete_group/>
                            <i class="fa fa-trash tw-text-sm"></i>
                        </DangerButton>
                        <Table class="mt-2">
                            <tr>
                                <th v-lang:name></th>
                                <th v-lang:price_adjustment></th>
                                <th v-lang:action></th>
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
                         :class="{
                            'show active': activeTabState === (i + product.product_has_option_groups.length),
                         }"
                         :id="`tab-add-${i}`">

                        <DangerButton @click="form.product_options.splice(i,1)">
                            <span v-lang:delete_group/>
                            <i class="fa fa-trash tw-text-sm"></i>
                        </DangerButton>

                        <div class="row mb-3 mt-3">
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