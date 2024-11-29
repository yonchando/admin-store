<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ColumnType } from "@/types/datatable/column";
import { computed, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import DataValue from "@/Components/DataValue.vue";
import Button from "@/Components/Button.vue";
import { Action } from "@/types/button";
import { Purchase, PurchaseDetail } from "@/types/models/purchase";
import purchaseService from "@/services/purchase.service";
import Card from "@/Components/Card/Card.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import { currency } from "@/number_format";
import { faCheck, faClipboardCheck, faFloppyDisk, faTimes } from "@fortawesome/free-solid-svg-icons";
import { useAlertStore } from "@/services/helper.service";
import TextareaInput from "@/Components/Forms/TextareaInput.vue";
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/Forms/InputError.vue";
import useAction from "@/services/action.service";

const props = defineProps<{
    purchase: Purchase;
}>();

const statuses = purchaseService.status;

const confirmed = ref(false);
const form = useForm({
    status: "",
    reason: "",
});

const actions = computed(() => {
    if (props.purchase.status === "pending") {
        const { edit } = useAction();

        edit.props.onClick = () => router.get(route("purchase.edit", props.purchase.id));
        return [
            {
                label: __("Accept"),
                component: Button,
                icon: faCheck,
                props: {
                    onClick() {
                        const alert = useAlertStore();

                        alert.show = true;
                        alert.text = "Do you want to accept this transaction?";
                        alert.type = "question";

                        alert.confirm = () => {
                            form.status = statuses.accepted;
                            updateStatus({
                                onFinish: () => {
                                    alert.show = false;
                                },
                            });
                        };
                    },
                    severity: "success",
                },
            },
            {
                label: "Reject",
                component: Button,
                icon: faTimes,
                props: {
                    onClick() {
                        form.status = statuses.rejected;
                        confirmed.value = true;
                    },
                    severity: "error",
                },
            },
            edit,
        ] as Action[];
    }

    if (props.purchase.status === statuses.accepted) {
        return [
            {
                label: "Mark Complete",
                component: Button,
                icon: faClipboardCheck,
                props: {
                    onClick() {
                        const alert = useAlertStore();

                        alert.show = true;
                        alert.text = "You want to complete this transaction?";
                        alert.type = "question";

                        alert.confirm = () => {
                            form.status = statuses.completed;
                            updateStatus({
                                onFinish: () => {
                                    alert.show = false;
                                },
                            });
                        };
                    },
                    severity: "success",
                },
            },
            {
                label: "Cancel",
                component: Button,
                icon: faTimes,
                props: {
                    onClick() {
                        confirmed.value = true;
                        form.status = statuses.cancel;
                    },
                    severity: "error",
                },
            },
        ] as Action[];
    }

    return [];
});

const columns = purchaseService.columns;

const productColumns = purchaseService.productColumns;

function updateStatus(options = {}) {
    form.patch(route("purchase.update.status", props.purchase.id), options);
}

function rejectOrCancel() {
    updateStatus({
        onSuccess: () => {
            confirmed.value = false;
        },
    });
}
</script>

<template>
    <AppLayout :title="purchase.ref_no" :actions="actions">
        <template #header>Purchase Detail</template>

        <div class="p-4">
            <div class="flex gap-3">
                <div class="flex w-8/12 flex-col gap-4">
                    <h3 class="text-lg font-semibold">Purchase Information</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <template v-for="column in columns">
                            <div class="flex">
                                <span class="w-1/3">{{ column.label }}:</span>
                                <span class="font-semibold">
                                    <DataValue :column="column" :item="purchase" />
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <template #additional_info>
            <Card class="mt-4">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Purchase Products</h3>

                    <DataTable
                        :root="{ rowClass: ['py-3'] }"
                        :columns="productColumns"
                        :values="purchase.purchase_details"
                        :filter="false"
                        :checkbox="false" />
                </div>
            </Card>
        </template>

        <Modal v-model:show="confirmed" :title="__(form.status + '_transaction')">
            <template #actions>
                <Button @click="rejectOrCancel" :icon="faFloppyDisk" severity="primary">Save</Button>
            </template>

            <div class="flex flex-col gap-2">
                <TextareaInput label="Reason" v-model="form.reason" required />
                <InputError :message="form.errors.reason" />
            </div>
        </Modal>
    </AppLayout>
</template>

<style scoped></style>
