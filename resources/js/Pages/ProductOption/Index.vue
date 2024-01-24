<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import FlashMessage from "@/Components/Alert/FlashMessage.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import Card from "@/Components/Card/Card.vue";
import Action from "@/Components/List/Action/Action.vue";
import Table from "@/Components/Table/Table.vue";
import {inject, reactive, ref} from "vue";
import Form from '@/Pages/ProductOption/Form.vue';
import DefaultButton from "@/Components/Button/DefaultButton.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import WarningButton from "@/Components/Button/WarningButton.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const props = defineProps({
    lang: Object,
    productOptions: Array
});

const lang = props.lang;

let isSelectedAll = ref(false);
let selectedId = ref([]);
let option = ref(null);

let form = useForm({
    options: []
});

function selectedAll() {
    if (isSelectedAll.value)
        selectedId.value = props.productOptions.map((value) => value.id);
    else
        selectedId.value = [];
}

function add() {
    form.options.push(reactive({
        name: null,
        price_adjustment: null,
    }));
}

function removeItem(i) {
    form.clearErrors();
    form.options.splice(i, 1);
}

function save() {
    form.post(route('product.option.store.many'), {
        onSuccess: params => {
            form.options = [];
        }
    });
}

function edit(value) {
    option.value = value;
}

const swal = inject('$swal');

function deleteSelected() {
    swal({
        title: lang.are_you_sure,
        text: lang.do_you_want_to_delete_this.replace(
            ":attribute",
            '',
        ),
        icon: "warning",
        confirmButtonClass: "btn btn-danger",
    }).then((res) => {
        if (res.value) {
            useForm({
                ids: selectedId.value
            }).delete(route('product.option.destroy.many'), {
                onSuccess: () => selectedId.value = [],
            });
        }
    });
}

</script>

<template>
    <Head :title="lang.product_options"/>

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem
                :title="lang.product_options"
                icon="icon-price-tags"
            />
        </template>

        <FlashMessage/>

        <Card :title="lang.options" collapse>
            <Table>
                <thead>
                    <th width="10">
                        <Checkbox v-model="isSelectedAll" @change="selectedAll()"/>
                    </th>
                    <th width="30">#</th>
                    <th width="40%">{{ lang.name }}</th>
                    <th>{{ lang.price_adjustment }}</th>
                    <th width="10%">{{ lang.action }}</th>
                </thead>

                <template v-if="productOptions.length > 0">
                    <tr v-for="(option,index) in productOptions">
                        <td>
                            <Checkbox type="checkbox" :value="option.id" :id="option.id"
                                      v-model="selectedId"
                            />
                        </td>
                        <td>{{ index + 1 }}</td>
                        <td class="text-capitalize">{{ option.name }}</td>
                        <td>{{ option.price_adjustment_text }}</td>
                        <td>
                            <Action>
                                <DropdownLink @click="edit(option)">
                                    <i class="icon-pencil7"></i>
                                    {{ lang.edit }}
                                </DropdownLink>
                            </Action>
                        </td>
                    </tr>
                </template>

                <tr v-else>
                    <td>{{ lang.empty }}</td>
                </tr>

                <template v-if="form.options.length > 0">
                    <tr v-for="(item,i) in form.options">
                        <td></td>
                        <td>{{ i + 1 + productOptions.length }}</td>
                        <td>
                            <TextInput v-model="item.name"/>
                            <span v-if="form.errors[`options.${i}.name`]" class="text-danger">
                                {{ form.errors[`options.${i}.name`] }}
                            </span>
                        </td>
                        <td>
                            <TextInput v-model="item.price_adjustment"/>
                        </td>
                        <td>
                            <a @click="removeItem(i)"
                               class="text-danger" href="#">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </template>
            </Table>
            <DefaultButton class="btn-link tw-ml-auto"
                           @click="add">
                {{ lang.add_option }}
            </DefaultButton>

            <template #footer v-if="form.options.length > 0 || selectedId.length > 0">
                <div class="tw-flex tw-justify-start tw-gap-2">
                    <template v-if="selectedId.length > 0">
                        <DangerButton @click="deleteSelected">
                            <i class="fa fa-trash"></i>
                            {{ lang.delete_selected }}
                        </DangerButton>
                    </template>

                    <template v-if="form.options.length > 0">
                        <PrimaryButton class="btn-sm"
                                       @click="save">
                            <i class="icon-floppy-disk tw-mr-2"></i>
                            {{ lang.save }}
                        </PrimaryButton>
                        <WarningButton @click="() => {form.options = []; form.clearErrors()}">
                            <i class="fa fa-trash"></i>
                            {{ lang.clear }}
                        </WarningButton>
                    </template>
                </div>
            </template>
        </Card>
    </AppLayout>

    <Form :open="open" :option="option" @close="() => {option = null; index = 1;}"/>
</template>

<style scoped>

</style>