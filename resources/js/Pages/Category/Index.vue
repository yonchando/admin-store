<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Card from "@/Components/Cards/Card.vue";
import Table from "@/Components/Tables/Table.vue";
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
import DropdownToggle from "@/Components/Dropdowns/DropdownToggle.vue";
import DropdownLink from "@/Components/Dropdowns/DropdownLink.vue";
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Modal from "@/Components/Modals/Modal.vue";
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import DefaultButton from "@/Components/Buttons/DefaultButton.vue";
import { onMounted, ref } from "vue";
import Paginate from "@/Components/Paginate.vue";

const { lang, categories } = defineProps(["lang", "categories"]);

const form = useForm({
    category_name: null,
});

let index = categories.from;

let category = null;

let title = ref("");

function create() {
    form.reset();
    category = null;
    title.value = "Create Form";
}

function edit(getCategory) {
    form.category_name = getCategory.category_name;
    category = getCategory;
    title.value = "Update Form";
}

function save() {
    index = categories.from;
    if (!category) {
        form.post(route("category.store"), {
            onSuccess: () => form.reset("category_name"),
        });
    } else {
        form.patch(route("category.update", category), {
            onSuccess: () => form.reset("category_name"),
        });
    }
}

function destroy() {
    index = categories.from;
}

onMounted(() => {});
</script>

<template>
    <AppLayout title="Categories">
        <BreadcrumbItem
            :title="lang.category"
            icon="icon-grid4"
            :href="route('category.index')"
        />
        <PrimaryButton type="button" @click="create()">
            <i class="icon-plus2"></i>
            {{ lang.add }}
        </PrimaryButton>

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

            <Paginate :data="categories" />
        </Card>
    </AppLayout>

    <Modal id="category-form" :title="title" center size="sm" bg="bg-info">
        <form @submit.prevent="save">
            <FormGroup>
                <InputLabel :value="lang.category_name" />
                <TextInput v-model="form.category_name" />
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
