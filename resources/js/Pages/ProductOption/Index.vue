<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Card from "@/Components/Card/Card.vue";
import Table from "@/Components/Table/Table.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import Modal from "@/Components/Modal/Modal.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import DefaultButton from "@/Components/Button/DefaultButton.vue";
import {onMounted, ref} from "vue";
import FlashMessage from "@/Components/Alert/FlashMessage.vue";
import Action from "@/Components/List/Action/Action.vue";

const {lang, groups} = defineProps(["lang", "groups"]);

const form = useForm({
    name: null,
});

let group = null;

let title = ref("");

let modal;

function create() {
    modal.modal("show");
    form.reset();
    group = null;
    title.value = "Create Form";
}

function edit(getCategory) {
    modal.modal("show");
    form.category_name = getCategory.category_name;
    group = getCategory;
    title.value = "Update Form";
}

function save() {
    if (!group) {
        form.post(route("category.store"), {
            onFinish: () => form.reset("category_name"),
        });
    } else {
        form.patch(route("category.update", group), {
            onFinish: () => form.reset("category_name"),
        });
    }

    modal.modal("hide");
}

onMounted(() => {
    modal = $("#category-form");
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

        <FlashMessage/>

        <Card title="Categories">
            <Table>
                <thead>
                    <th width="30">#</th>
                    <th>{{ lang.name }}</th>
                    <th width="10%">{{ lang.action }}</th>
                </thead>

                <template v-if="groups.length > 0">
                    <tr v-for="(group,i) in groups">
                        <td>{{ i + 1 }}</td>
                        <td>{{ group.name }}</td>
                        <td>
                            <Action>
                                <DropdownLink @click="edit(group)">
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
            </Table>
        </Card>
    </AppLayout>

    <modal id="category-form" :title="title" center size="sm" bg="bg-info">
        <form @submit.prevent="save">
            <FormGroup>
                <InputLabel :value="lang.name"/>
                <TextInput v-model="form.name"/>
            </FormGroup>

            <FormGroup class="tw-space-x-2">
                <PrimaryButton type="submit">
                    {{ lang.save }}
                </PrimaryButton>
                <DefaultButton data-dismiss="modal"> Close</DefaultButton>
            </FormGroup>
        </form>
    </modal>
</template>

