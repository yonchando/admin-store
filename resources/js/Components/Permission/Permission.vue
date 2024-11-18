<script setup lang="ts">
import Checkbox from "@/Components/Forms/Checkbox.vue";
import { Module, Permission } from "@/types/models/module";
import { onMounted, reactive, ref, watch } from "vue";
import axios from "axios";
import { Role } from "@/types/models/role";
import _ from "lodash";

const props = withDefaults(
    defineProps<{
        values?: any;
        disabled?: any;
    }>(),
    { disabled: {}, values: {} },
);

const data: { modules: Module[] } = reactive({
    modules: [],
});

const permissions = defineModel<any>();

function isCheckedAll(module: Module) {
    if (
        props.disabled[module.id] &&
        module.permissions?.length === _.uniq([...props.disabled[module.id], ...permissions.value[module.id]]).length
    ) {
        return true;
    }

    if (permissions.value[module.id] && module.permissions?.length === permissions.value[module.id].length) {
        return true;
    }

    return module.permissions?.length === props.disabled[module.id]?.length;
}

function checkedAll(event: Event, module: Module) {
    const input = event.target as HTMLInputElement;

    if (input.checked) {
        permissions.value[module.id] = module.permissions?.map((item) => item.id);
    } else {
        permissions.value[module.id] = [];
    }
}

function setDefaultValue(values: { [key: number]: number[] }) {
    if (values) {
        for (const key in values) {
            const module = data.modules.find((item: Module) => item.id === Number(key));
            if (module && values[key].length) {
                permissions.value[key] = values[key];
            }
        }
    }
}

function setDisabled(module: Module, permission: Permission) {
    if (props.disabled && typeof props.disabled[module.id] != "undefined") {
        return props.disabled[module.id].includes(permission.id);
    }

    return false;
}

onMounted(() => {
    permissions.value = {};
    axios
        .get(route("ajax.modules.index"))
        .then((res) => {
            data.modules = res.data.modules;

            for (const module of data.modules) {
                permissions.value[module.id] = [];
            }
        })
        .then(() => {
            setDefaultValue(props.values);
        });
});
</script>

<template>
    <div class="mt-4 flex flex-col gap-4">
        <div class="border border-gray-700"></div>
        <template v-if="data.modules.length > 0">
            <template v-for="module in data.modules">
                <div class="flex gap-4">
                    <div class="min-w-28">
                        {{ module.name }}
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <Checkbox
                                :id="`${module.id}-all`"
                                :checked="isCheckedAll(module)"
                                :disabled="module.permissions?.length === disabled[module.id]?.length"
                                @change="checkedAll($event, module)" />
                            <label class="cursor-pointer" :for="`${module.id}-all`">All</label>
                        </div>

                        <template v-for="permission in module.permissions">
                            <div class="flex items-center gap-2">
                                <Checkbox
                                    v-if="setDisabled(module, permission)"
                                    :id="`${module.id}-${permission.id}`"
                                    :checked="true"
                                    :disabled="setDisabled(module, permission)" />

                                <Checkbox
                                    v-else
                                    :id="`${module.id}-${permission.id}`"
                                    v-model:checked="permissions[module.id]"
                                    :value="permission.id" />
                                <label class="cursor-pointer" :for="`${module.id}-${permission.id}`">
                                    {{ permission.name }}
                                </label>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="border border-gray-700"></div>
            </template>
        </template>
    </div>
</template>

<style scoped></style>
