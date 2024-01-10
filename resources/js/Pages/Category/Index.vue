<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import Card from "@/Components/Card/Card.vue";
import Table from "@/Components/Table/Table.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import Modal from "@/Components/Modal/Modal.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import DefaultButton from "@/Components/Button/DefaultButton.vue";
import {onBeforeMount, onMounted, onUpdated, reactive, ref, watch} from "vue";
import {inject} from "vue";

const {lang, categories} = defineProps(["lang", "categories"]);

const form = useForm({
    category_name: null,
});

let index = categories.from;

let category = null;

let title = ref("");

let $category;

function create() {
    $category.modal("show");
    form.reset();
    category = null;
    title.value = "Create Form";
}

function edit(getCategory) {
    $category.modal("show");
    form.category_name = getCategory.category_name;
    category = getCategory;
    title.value = "Update Form";
}

function save() {
    index = categories.from;
    if (!category) {
        form.post(route("category.store"), {
            onFinish: () => form.reset("category_name"),
        });
    } else {
        form.patch(route("category.update", category), {
            onFinish: () => form.reset("category_name"),
        });
    }

    $category.modal("hide");
}

const swal = inject("$swal");

function destroy(category) {
    index = categories.from;
    swal({
        title: "Are you sure?",
        text: lang.do_you_want_to_delete_this.replace(
            ":attribute",
            category.category_name,
        ),
        icon: "warning",
        confirmButtonClass: "btn btn-danger",
    }).then((res) => {
        if (res.value) {
            useForm({}).delete(route("category.destroy", category));
        }
    });
}

onMounted(() => {
    $category = $("#category-form");
});
</script>

<template>
    <Head title="Category"/>

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem
                :title="lang.category"
                icon="icon-grid4"
                :href="route('category.index')"
            />
        </template>

        <template #action>
            <PrimaryButton type="button" @click="create()">
                <i class="icon-plus2"></i>
                {{ lang.add }}
            </PrimaryButton>
        </template>

        <div
            v-if="$page.props.flash.message || form.recentlySuccessful"
            class="alert alert-success"
        >
            {{ $page.props.flash.message }}
        </div>

        <Card title="Categories">
            <Table>
                <thead>
                    <th width="30">#</th>
                    <th>{{ lang.name }}</th>
                    <th width="10%">{{ lang.action }}</th>
                </thead>

                <template v-if="categories.data.length > 0">
                    <tr v-for="category in categories.data">
                        <td>{{ index++ }}</td>
                        <td>{{ category.category_name }}</td>
                        <td>
                            <Dropdown>
                                <template #toggle>
                                    <DropdownToggle>
                                        <i class="icon-list2"></i>
                                    </DropdownToggle>
                                </template>

                                <DropdownLink @click="edit(category)">
                                    <i class="icon-pencil7"></i>
                                    {{ lang.edit }}
                                </DropdownLink>

                                <DropdownLink @click="destroy(category)">
                                    <i class="icon-trash-alt"></i>
                                    {{ lang.delete }}
                                </DropdownLink>
                            </Dropdown>
                        </td>
                    </tr>
                </template>

                <tr v-else>
                    <td>{{ lang.empty }}</td>
                </tr>
            </Table>
        </Card>
    </AppLayout>

    <Modal id="category-form" :title="title" center size="sm" bg="bg-info">
        <form @submit.prevent="save">
            <FormGroup>
                <InputLabel :value="lang.category_name"/>
                <TextInput v-model="form.category_name"/>
            </FormGroup>

            <FormGroup class="tw-space-x-2">
                <PrimaryButton type="submit">
                    {{ lang.save }}
                </PrimaryButton>
                <DefaultButton data-dismiss="modal"> Close</DefaultButton>
            </FormGroup>
        </form>
    </Modal>
</template>

<style scoped></style>
