<script setup>

import {Head} from "@inertiajs/vue3";

import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Card from "@/Components/Card/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import Action from "@/Components/List/Action/Action.vue";

import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";

const {lang} = defineProps({
    productOptionGroup: Object,
    productOptions: Array,
    lang: Object
})

</script>

<template>
    <Head :title="productOptionGroup.name"/>

    <AppLayout>
        <template #breadcrumb>
            <BreadcrumbItem :href="route('product.option.group.index')" icon="icon-box"
                            :title="lang.product_option"/>
            <BreadcrumbItem icon="fa fa-box-open" :title="lang.detail"/>
        </template>

        <Card no-header>
            <div class="row">
                <div class="col-6">
                    <div class="tw-space-y-3">
                        <ListItem :label="lang.name" :value="productOptionGroup.name"/>
                    </div>
                </div>
            </div>
        </Card>

        <Card :title="lang.options" collapse>
            <Table>
                <thead>
                <th width="30">#</th>
                <th>{{ lang.name }}</th>
                <th>{{ lang.price_adjustment }}</th>
                <th width="10%">{{ lang.action }}</th>
                </thead>

                <template v-if="productOptions.length > 0">
                    <tr v-for="(option,i) in productOptions">
                        <td>{{ i + 1 }}</td>
                        <td>{{ option.name }}</td>
                        <td>{{ option.price_adjustment_text }}</td>
                        <td>
                            <Action>
                                <DropdownLink @click="edit(option)">
                                    <i class="icon-pencil7"></i>
                                    {{ lang.edit }}
                                </DropdownLink>
                            </Action>
                        </td>
                    </tr>
                </template>

                <tr v-else>
                    <td>{{ lang.empty }}</td>
                </tr>
            </Table>
        </Card>
    </AppLayout>
</template>

<style scoped>

</style>
