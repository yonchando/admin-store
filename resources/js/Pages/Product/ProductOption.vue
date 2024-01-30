<script setup>
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import InputError from "@/Components/Form/InputError.vue";
import Table from "@/Components/Table/Table.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import Card from "@/Components/Card/Card.vue";
import InfoButton from "@/Components/Button/InfoButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, inject, nextTick, onMounted, ref } from "vue";
import WarningButton from "@/Components/Button/WarningButton.vue";

onMounted(() => {
    $("#product-options li:first-child a.nav-link").tab("show");
});

const props = defineProps({
    product: Object,
    groups: Array,
    options: Array,
});

const page = usePage();

const lang = page.props.lang;

const form = useForm({
    product_options: [],
    options: {},
});

const getGroups = computed(() => {
    const groupIds = props.product.product_has_option_groups.map(
        (value) => value.product_option_group_id,
    );

    const formGroupIds = form.product_options.map(
        (value) => value.product_option_group_id,
    );

    return props.groups.filter(
        (value) =>
            !groupIds.includes(value.id) && !formGroupIds.includes(value.id),
    );
});

const getOptions = computed(() => {
    const productOptionIds = props.product.product_has_option_groups.flatMap(
        (group) => {
            return group.product_has_options.map(
                (option) => option.product_option_id,
            );
        },
    );

    const formOptionIds = Object.values(form.options).flatMap((item) => {
        return item.map((value) => value.product_option_id);
    });

    const formProductOptionIds = form.product_options.flatMap((group) => {
        return group.options.map((option) => option.product_option_id);
    });

    return props.options.filter((value) => {
        return (
            !productOptionIds.includes(value.id) &&
            !formOptionIds.includes(value.id) &&
            !formProductOptionIds.includes(value.id)
        );
    });
});

const formHasOptions = computed(() =>
    Object.values(form.options).filter((value) => value.length > 0),
);

function selectTab() {
    nextTick(() => {
        $("#product-options li:last-child a.nav-link").tab("show");
    });
}

function groupName(group) {
    const item = props.groups.find(
        (value) => value.id === group.product_option_group_id,
    );

    if (!item) {
        return "New Group";
    }
    return item.name;
}

function addGroup() {
    form.product_options.push({
        product_option_group_id: null,
        options: [
            {
                product_option_id: null,
                price_adjustment: null,
            },
        ],
    });

    selectTab();
}

const swal = inject("$swal");

function deleteGroup(group) {
    swal({
        title: lang.are_you_sure,
        html:
            lang.do_you_want_to_delete_this.replace(
                ":attribute",
                group.product_option_group.name,
            ) + `<br> ${lang.cant_undo}`,
        icon: "warning",
        confirmButtonClass: "btn btn-danger",
    }).then((res) => {
        if (res.value) {
            useForm({}).delete(
                route("product.destroy.product.option.group", group),
                {
                    onSuccess: () => selectTab(),
                },
            );
        }
    });
}

function deleteNewGroup(i) {
    form.product_options.splice(i, 1);
    selectTab();
    formOption.clearErrors();
}

function deleteOption(option) {
    swal({
        title: lang.are_you_sure,
        html:
            lang.do_you_want_to_delete_this.replace(
                ":attribute",
                option.product_option.name,
            ) + `<br> ${lang.cant_undo}`,
        icon: "warning",
        confirmButtonClass: "btn btn-danger",
    }).then((res) => {
        if (res.value) {
            useForm({}).delete(route("product.destroy.product.option", option));
        }
    });
}

function deleteNewOption(group, index) {
    form.options[group.id].splice(index, 1);
    formOption.clearErrors();
}

function addOption(group) {
    if (typeof form.options[group.id] === "undefined") {
        form.options[group.id] = [];
    }

    form.options[group.id].push({
        product_has_option_group_id: group.id,
        product_option_id: null,
        price_adjustment: null,
    });
}

const formOption = useForm({
    options: [],
});

function save() {
    new Promise((resolve) => {
        if (form.product_options.length > 0) {
            form.post(route("product.store.product.option", props.product), {
                preserveScroll: true,
                onSuccess: () => {
                    form.reset("product_options");
                    selectTab();
                },
                onFinish: () => {
                    resolve();
                },
            });
        } else {
            resolve();
        }
    }).then(() => {
        if (form.options) {
            formOption.options = [].concat(Object.values(form.options)).flat();
            formOption.post(route("product.add.option", props.product), {
                onSuccess: () => {
                    form.options = {};
                },
            });
        }
    });
}

function clear() {
    form.reset();
    formOption.reset();
}
</script>

<template>
    <Card :title="lang.product_options" class="product-options">
        <InfoButton
            v-if="getGroups.length > 0"
            @click="addGroup"
            class="tw-mb-3"
        >
            <i class="icon-plus2"></i>
            {{ lang.add_group }}
        </InfoButton>

        <ul class="nav nav-tabs nav-tabs-bottom" id="product-options">
            <template v-for="group in product.product_has_option_groups">
                <li class="nav-item tw-flex tw-items-center">
                    <a
                        :href="`#tab-${group.id}`"
                        class="nav-link tw-peer"
                        role="tab"
                        data-toggle="tab"
                    >
                        {{ group.product_option_group.name }}
                    </a>
                </li>
            </template>
            <template v-for="(group, i) in form.product_options">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :href="`#tab-add-${i}`"
                        role="tab"
                        data-toggle="tab"
                    >
                        {{ groupName(group) }}
                        <i
                            v-if="
                                form.errors[
                                    `product_options.${i}.product_option_group_id`
                                ]
                            "
                            class="fa fa-exclamation text-danger tw-ml-2 tw-text-xs"
                        ></i>
                    </a>
                </li>
            </template>
        </ul>
        <div class="tab-content">
            <template v-for="(group, i) in product.product_has_option_groups">
                <div class="tab-pane fade" :id="`tab-${group.id}`">
                    <div class="tw-flex tw-gap-4">
                        <DangerButton @click="deleteGroup(group)">
                            <span v-lang:delete_group />
                            <i class="fa fa-trash tw-text-sm"></i>
                        </DangerButton>
                        <InfoButton
                            v-if="getOptions.length > 0"
                            @click="addOption(group)"
                        >
                            <i class="icon-plus2"></i>
                            {{ lang.add_option }}
                        </InfoButton>
                    </div>

                    <Table class="mt-2">
                        <tr>
                            <th width="40%" v-lang:name></th>
                            <th v-lang:price_adjustment></th>
                            <th v-lang:action></th>
                        </tr>

                        <template v-for="option in group.product_has_options">
                            <tr>
                                <td class="text-capitalize">
                                    {{ option.product_option.name }}
                                </td>
                                <td>{{ option.price_adjustment_text }}</td>
                                <td>
                                    <i
                                        @click="deleteOption(option)"
                                        class="fa fa-trash text-danger tw-cursor-pointer"
                                    ></i>
                                </td>
                            </tr>
                        </template>
                        <template
                            v-if="
                                group.product_has_options.length === 0 &&
                                typeof form.options[group.id] === 'undefined'
                            "
                        >
                            <tr>
                                <td colspan="3">{{ lang.empty }}</td>
                            </tr>
                        </template>

                        <template v-for="(option, j) in form.options[group.id]">
                            <tr>
                                <td>
                                    <SelectInput
                                        v-model="option.product_option_id"
                                        text="name"
                                        :items="getOptions"
                                    />
                                    <InputError
                                        :message="
                                            formOption.errors[
                                                `options.${j}.product_option_id`
                                            ]
                                        "
                                    />
                                </td>
                                <td>
                                    <TextInput
                                        v-model="option.price_adjustment"
                                    />
                                    <InputError
                                        :message="
                                            form.errors[
                                                `options.${j}.price_adjustment`
                                            ]
                                        "
                                    />
                                </td>
                                <td style="vertical-align: middle">
                                    <i
                                        @click="deleteNewOption(group, j)"
                                        class="fa fa-trash text-danger tw-cursor-pointer"
                                    ></i>
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
            </template>

            <template v-for="(group, i) in form.product_options">
                <div class="tab-pane fade" :id="`tab-add-${i}`">
                    <div class="tw-flex tw-gap-4">
                        <DangerButton @click="deleteNewGroup(i)">
                            <span v-lang:delete_group />
                            <i class="fa fa-trash tw-text-sm"></i>
                        </DangerButton>

                        <InfoButton
                            @click="
                                group.options.push({
                                    product_option_id: null,
                                    price_adjustment: null,
                                })
                            "
                        >
                            {{ lang.add_option }}
                        </InfoButton>
                    </div>

                    <div class="row mb-3 mt-3">
                        <div class="col-4">
                            <InputLabel :value="lang.product_option_group" />
                            <SelectInput
                                :items="getGroups"
                                text="name"
                                v-model="group.product_option_group_id"
                            />
                            <InputError
                                :message="
                                    form.errors[
                                        `product_options.${i}.product_option_group_id`
                                    ]
                                "
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div
                                class="form-group tw-grid tw-grid-cols-3 tw-items-start tw-gap-4"
                            >
                                <template v-for="(option, j) in group.options">
                                    <div class="">
                                        <InputLabel :value="lang.option" />
                                        <SelectInput
                                            v-model="option.product_option_id"
                                            text="name"
                                            :items="getOptions"
                                        />
                                        <InputError
                                            :message="
                                                form.errors[
                                                    `product_options.${i}.options.${j}.product_option_id`
                                                ]
                                            "
                                        />
                                    </div>
                                    <div class="">
                                        <InputLabel
                                            :value="lang.price_adjustment"
                                        />
                                        <TextInput
                                            v-model="option.price_adjustment"
                                        />
                                        <InputError
                                            :message="
                                                form.errors[
                                                    `product_options.${i}.options.${j}.price_adjustment`
                                                ]
                                            "
                                        />
                                    </div>
                                    <div
                                        class="tw-flex tw-h-full tw-items-center"
                                    >
                                        <DangerButton
                                            @click="group.options.splice(j, 1)"
                                            v-if="j !== 0"
                                        >
                                            <i class="fa fa-trash"></i>
                                            {{ lang.delete }}
                                        </DangerButton>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <template
            #footer
            v-if="form.product_options.length > 0 || formHasOptions.length > 0"
        >
            <div class="tw-flex tw-gap-4">
                <PrimaryButton @click="save()" :disabled="form.processing">
                    <i class="icon-floppy-disk"></i>
                    <span>{{ lang.save }}</span>
                </PrimaryButton>

                <WarningButton @click="clear()" :disabled="form.processing">
                    <i class="fa fa-times"></i>
                    <span>{{ lang.clear }}</span>
                </WarningButton>
            </div>
        </template>
    </Card>
</template>

<style scoped>
.table td {
    vertical-align: top;
}
</style>
