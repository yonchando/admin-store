<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import Card from "@/Components/Card/Card.vue";
import Table from "@/Components/Table/Table.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import Modal from "@/Components/Modal/Modal.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import DefaultButton from "@/Components/Button/DefaultButton.vue";
import {onMounted, ref} from "vue";
import Action from "@/Components/List/Action/Action.vue";
import DeleteAction from "@/Components/List/Action/DeleteAction.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

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

function edit(value) {
    group = value;
    title.value = "Update Form";
    form.name = group.name;
    modal.modal("show");
}

function save() {
    if (!group) {
        form.post(route("product.option.group.store"));
    } else {
        form.patch(route("product.option.group.update", group));
    }

    form.reset();
    modal.modal("hide");
}

onMounted(() => {
    modal = $("#modal-form");
});
</script>

<template>
    <Head :title="lang.option_groups"/>

    <AppLayout>
        <template #action>
            <PrimaryButton type="button" @click="create()">
                <i class="icon-plus2"></i>
                {{ lang.add }}
            </PrimaryButton>
        </template>

        <Card :title="lang.option_groups">
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

                                <DeleteAction :url="route('product.option.group.destroy',group)" :text="group.name"/>

                            </Action>
                        </td>
                    </tr>
                </template>

                <tr v-else>
                    <td>{{ lang.empty }}</td>
                </tr>
            </Table>
        </Card>

        <Modal id="modal-form" :title="title" center size="sm" bg="bg-info">
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
        </Modal>
    </AppLayout>
</template>