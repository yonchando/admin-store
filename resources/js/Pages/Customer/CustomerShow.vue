<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ColumnType } from "@/types/datatable/column";
import { computed, onMounted } from "vue";
import useAction from "@/services/action.service";
import { router, useForm } from "@inertiajs/vue3";
import DataValue from "@/Components/DataValue.vue";
import { Role } from "@/types/models/role";
import { Paginate } from "@/types/paginate";
import { Customer } from "@/types/models/customer";
import { useAlertStore } from "@/services/helper.service";
import customerService from "@/services/customer.service";

const props = defineProps<{
    customer: Customer;
    permissions: { [key: number]: number[] };
    roles: Paginate<Role>;
}>();

const actions = computed(() => {
    const { edit, remove } = useAction();

    edit.props.onClick = () => {
        router.get(route("customer.edit", props.customer.id));
    };

    remove.props.onClick = () => {
        const alert = useAlertStore();
        alert.open();

        alert.confirm = () => {
            useForm({
                ids: [props.customer.id],
            }).delete(route("customer.destroy"), {
                onFinish: () => {
                    alert.$reset();
                },
            });
        };
    };

    return [edit, remove];
});

const columns: ColumnType<Customer>[] = customerService.columns;

onMounted(() => {});
</script>

<template>
    <AppLayout :title="`Customer ${customer.name}`" :actions="actions">
        <template #header>Customer Detail</template>

        <div class="p-4">
            <h3 class="mb-4 text-xl font-semibold">Information</h3>
            <div class="flex gap-3">
                <div class="flex w-8/12 flex-col gap-4">
                    <div class="grid grid-cols-2 gap-6">
                        <template v-for="column in columns">
                            <div class="flex">
                                <span class="w-1/3">{{ column.label }}:</span>
                                <span class="font-semibold">
                                    <DataValue :column="column" :item="customer" />
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="w-4/12" v-if="customer.profile">
                    <img :src="customer.profile.url" alt="" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
