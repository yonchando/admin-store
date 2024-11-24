<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Product } from "@/types/models/product";
import { ColumnType } from "@/types/datatable/column";
import productService from "@/services/product.service";
import { computed, nextTick, ref, watch } from "vue";
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

const { role } = defineProps<{
    role: Role;
    permissions: { [key: number]: number[] };
}>();

const confirmed = ref(false);

const actions = computed(() => {
    const { save, edit, remove } = useAction();

    save.props.onClick = updatePermission;

    edit.props.onClick = () => {
        router.get(route("role.edit", role.id));
    };

    remove.props.onClick = () => {
        confirmed.value = true;
    };

    return [save, edit, remove];
});

const columns: ColumnType<Role>[] = roleService.columns;

const form = useForm({
    permissions: {} as { [key: number]: number[] },
});

function updatePermission() {
    form.patch(route("role.patch.permissions", role.id));
}

function destroy() {
    useForm({
        ids: [role.id],
    }).delete(route("product.destroy"));
}
</script>

<template>
    <AppLayout :title="`Role ${role.name}`" :actions="actions">
        <template #header> Role Detail</template>

        <div class="p-4">
            <h3 class="mb-4 text-xl font-semibold">Information</h3>
            <div class="flex gap-3">
                <div class="flex w-8/12 flex-col gap-4">
                    <div class="grid grid-cols-2 gap-6">
                        <template v-for="column in columns">
                            <div class="flex">
                                <span class="w-1/3">{{ column.label }}:</span>
                                <span class="font-semibold">
                                    <DataValue :column="column" :item="role" />
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <h3 class="text-xl">Permissions</h3>
            </div>

            <div>
                <Permission :values="permissions" v-model="form.permissions" />
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
