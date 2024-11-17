<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Product } from "@/types/models/product";
import { Column } from "@/types/datatable/column";
import productService from "@/services/product.service";
import { computed, nextTick, onMounted, ref, watch } from "vue";
import useAction from "@/services/action.service";
import { router, useForm } from "@inertiajs/vue3";
import Alert from "@/Components/Alert/Alert.vue";
import DataValue from "@/Components/DataValue.vue";
import Button from "@/Components/Button.vue";
import { useCropper } from "@/services/cropper.service";
import FileUpload from "@/Components/Forms/FileUpload.vue";
import { Action } from "@/types/button";
import { faUpload } from "@fortawesome/free-solid-svg-icons";
import { UploadFile } from "@/types";
import { Role } from "@/types/models/role";
import roleService from "@/services/role.service";
import Permission from "@/Components/Permission/Permission.vue";
import { Staff } from "@/types/models/staff";
import staffService from "@/services/staff.service";
import Badge from "@/Components/Badges/Badge.vue";
import _ from "lodash";
import { Paginate } from "@/types/paginate";
import Select from "@/Components/Forms/Select.vue";

const props = defineProps<{
    staff: Staff;
    permissions: { [key: number]: number[] };
    roles: Paginate<Role>;
}>();

const staff = props.staff;

const confirmed = ref(false);

const actions = computed(() => {
    const { save, edit, remove } = useAction();

    save.props.onClick = updateRolePermission;

    edit.props.onClick = () => {
        router.get(route("staff.edit", staff.id));
    };

    remove.props.onClick = () => {
        confirmed.value = true;
    };

    return [save, edit, remove];
});

const columns: Column<Staff>[] = staffService.columns;

const form = useForm({
    role_ids: [] as number[],
    permission_ids: {} as { [key: number]: number[] },
});

const disabled = ref<any>({});

function selectRole() {
    let roles = props.roles.data.filter((item) => form.role_ids.includes(item.id));

    disabled.value = {};
    for (const role of roles) {
        for (const module_id in role.permission_id_by_module_keys) {
            let value: Array<number> = [];
            if (typeof disabled.value[module_id] !== "undefined") {
                value = disabled.value[module_id];
            }

            disabled.value[module_id] = _.uniq([...value, ...role.permission_id_by_module_keys[module_id]]);
        }
    }
}

function updateRolePermission() {
    form.patch(route("staff.patch.role.permission", staff.id));
}

function destroy() {
    useForm({
        ids: [staff.id],
    }).delete(route("staff.destroy"));
}

onMounted(() => {
    form.role_ids = props.staff.roles?.map((item) => item.id);
    selectRole();
});
</script>

<template>
    <AppLayout :title="`Role ${staff.name}`" :actions="actions">
        <template #header> Role Detail</template>

        <div class="p-4">
            <h3 class="mb-4 text-xl font-semibold">Information</h3>
            <div class="flex gap-3">
                <div class="flex w-8/12 flex-col gap-4">
                    <div class="grid grid-cols-2 gap-6">
                        <template v-for="column in columns">
                            <div class="flex">
                                <span class="w-1/3">{{ column.label }}:</span>
                                <span class="font-semibold" v-bind="column.props">
                                    <DataValue :column="column" :item="staff" />
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="mt-6 w-1/3">
                <h2 class="text-xl">Role</h2>
                <Select
                    multiple
                    v-model="form.role_ids"
                    @change="selectRole"
                    :options="roles.data"
                    :paginate="roles"
                    option-label="code"
                    option-value="id" />
            </div>

            <div class="mt-6 flex items-center justify-between">
                <h3 class="text-xl">Permissions</h3>
            </div>

            <div>
                <Permission
                    :values="staff.permission_id_by_module_keys"
                    :disabled="disabled"
                    v-model="form.permission_ids" />
            </div>
        </div>

        <Alert
            @confirmed="destroy()"
            type="warning"
            title="Are you sure?"
            text="Do you want to delete this?"
            v-model:show="confirmed"
            confirm-button-type="error" />
    </AppLayout>
</template>

<style scoped></style>
