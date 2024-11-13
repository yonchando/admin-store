<script setup lang="ts">
import Checkbox from "@/Components/Forms/Checkbox.vue";
import { Module, Permission } from "@/types/models/module";
import { onMounted, reactive, ref } from "vue";
import axios from "axios";

const props = defineProps<{
    values: { [key: number]: number[] };
}>();

const data: { modules: Module[] } = reactive({
    modules: [],
});

const permissions = defineModel<any>();

const checked = ref<any>({});

function checkedAll(event: Event, module: Module) {
    const input = event.target as HTMLInputElement;

    if (input.checked) {
        permissions.value[module.id] = module.permissions?.map((item) => item.id);
    } else {
        permissions.value[module.id] = [];
    }
}

function check(module: Module) {
    checked.value[module.id] = module.permissions?.length === permissions.value[module.id].length;
}

onMounted(() => {
    axios
        .get(route("ajax.modules.index"))
        .then((res) => {
            data.modules = res.data.modules;

            for (const module of data.modules) {
                permissions.value[module.id] = [];
            }
        })
        .then(() => {
            if (props.values) {
                for (const key in props.values) {
                    const module = data.modules.find((item: Module) => item.id === Number(key));
                    if (module) {
                        checked.value[module.id] = module?.permissions?.length == props.values[key].length;
                        permissions.value[key] = props.values[key];
                    }
                }
            }
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
                                v-model:checked="checked[module.id]"
                                @change="checkedAll($event, module)"
                                :value="module.id" />
                            <label class="cursor-pointer" :for="`${module.id}-all`">All</label>
                        </div>

                        <template v-for="permission in module.permissions">
                            <div class="flex items-center gap-2">
                                <Checkbox
                                    :id="`${module.id}-${permission.id}`"
                                    v-model:checked="permissions[module.id]"
                                    @change="check(module)"
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
