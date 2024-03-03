<script setup>
import Card from "@/Components/Card/Card.vue";
import Modal from "@/Components/Modal/Modal.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import {inject, reactive, ref} from "vue";
import DefaultButton from "@/Components/Button/DefaultButton.vue";
import Badge from "@/Components/Badge/Badge.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import FlashMessage from "@/Components/Alert/FlashMessage.vue";

defineProps(['cards']);

const form = useForm({
    name: null,
});

const editForm = reactive({
    card: null,
});

const selected = ref(null);

const lang = usePage().props.lang;

function save() {
    if (editForm.card) {
        form.put(route('card.update', editForm.card), {
            onSuccess: () => form.reset('name')
        });
    } else {
        form.post(route('card.store'));
    }
    $("#form-card").modal('hide');
}

function edit(card) {
    form.name = card.name;
    editForm.card = card;
    $("#form-card").modal('show');
}

const swal = inject("$swal");

function destroy(card) {
    swal({
        title: lang.are_you_sure,
        text: lang.do_you_want_to_delete_this.replace(
            ":attribute",
            card.name,
        ),
        icon: "warning",
        confirmButtonClass: "btn btn-danger",
    }).then((res) => {
        if (res.value) {
            router.delete(route('card.destroy', card));
        }
    });
}
</script>

<template>
    <Head :title="lang.card"/>

    <AppLayout>

        <template #action>
            <PrimaryButton data-toggle="modal" data-target="#form-card">
                <i class="icon-plus2"></i>
                Add Card
            </PrimaryButton>
        </template>

        <FlashMessage/>

        <Card :title="lang.cards">
            <Table>
                <Tr>
                    <th style="width: 5%;">#</th>
                    <th>{{ lang.name }}</th>
                    <th style="width: 20%;">{{ lang.status }}</th>
                    <th style="width: 10%;">{{ lang.action }}</th>
                </Tr>

                <template v-if="cards.length > 0">
                    <Tr v-for="(card,i) in cards"
                        :key="card.id"
                        @click="selected = card.id"
                        :class="{'tw-bg-gray-200': selected === card.id}"
                        class="tw-cursor-pointer"
                        @dblclick.prevent="router.get(route('card.show',card))">
                        <Td>{{ i + 1 }}</Td>
                        <Td>
                            {{ card.name }}
                        </Td>
                        <Td>
                            <Badge :value="card.status"/>
                        </td>
                        <Td>
                            <Dropdown>
                                <template #toggle>
                                    <DropdownToggle>
                                        <i class="icon-list2"></i>
                                    </DropdownToggle>
                                </template>

                                <DropdownLink
                                    @click="edit(card)"
                                >
                                    <i class="icon-pencil7"></i>
                                    {{ lang.edit }}
                                </DropdownLink>

                                <DropdownLink @click="destroy(card)">
                                    <i class="icon-trash-alt"></i>
                                    {{ lang.delete }}
                                </DropdownLink>
                            </Dropdown>
                        </Td>
                    </tr>
                </template>
            </Table>
        </Card>

        <Modal :title="editForm.card ? $lang.edit : $lang.add" id="form-card" center>
            <form action="">
                <form-group>
                    <input-label :value="$lang.name"/>
                    <text-input v-model="form.name"/>
                </form-group>
            </form>

            <PrimaryButton @click="save" class="mr-2">
                {{ $lang.save }}
            </PrimaryButton>
            <DefaultButton data-dismiss="modal" @click="form.reset(); editForm.card=null;">
                {{ $lang.cancel }}
            </DefaultButton>
        </Modal>
    </AppLayout>

</template>

<style scoped>

</style>
