<script setup>

import TextInput from "@/Components/Form/TextInput.vue";
import Modal from "@/Components/Modal/Modal.vue";
import DefaultButton from "@/Components/Button/DefaultButton.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import {onMounted, ref, watch} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";

const lang = usePage().props.lang;

const props = defineProps({
    option: Object,
});

const form = useForm({
    name: null,
    price_adjustment: null,
});

let modal;

const $emit = defineEmits(['close']);

watch(() => props.option, (option) => {
    if (option) {
        form.name = option.name;
        form.price_adjustment = option.price_adjustment;
    }
    modal.modal(option ? 'show' : 'hide');
});

function save() {
    form.patch(route("product.option.update", props.option));
    form.reset();
    modal.modal("hide");
}

onMounted(() => {
    modal = $("#form-product-option");

    modal.on('hide.bs.modal', function () {
        $emit('close');
        form.reset();
    })

    if (form.errors.length > 0) {
        modal.modal('show')
    }
});
</script>

<template>
    <Modal id="form-product-option" :title="lang.update" center size="sm" bg="bg-info">
        <form @submit.prevent="save">
            <FormGroup>
                <InputLabel :value="lang.name"/>
                <TextInput v-model="form.name"/>
            </FormGroup>
            <FormGroup>
                <InputLabel :value="lang.price_adjustment"/>

                <TextInput type="number" step="0.00" v-model="form.price_adjustment"/>
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

<style scoped>

</style>