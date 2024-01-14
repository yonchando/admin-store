<script setup>
import {Head} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card/Card.vue";
import Table from "@/Components/Table/Table.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import WarningButton from "@/Components/Button/WarningButton.vue";
import BreadcrumbItem from "@/Components/Breadcrumb/BreadcrumbItem.vue";
import Action from "@/Components/List/Action/Action.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import EditAction from "@/Components/List/Action/EditAction.vue";
import DeleteAction from "@/Components/List/Action/DeleteAction.vue";

const {staffs} = defineProps(['lang', 'staffs'])


let index = staffs.from;

</script>

<template>
    <Head :title="lang.staffs"/>

    <AppLayout>

        <template #action>
            <WarningButton class="tw-mr-2">
                <i class="icon-filter3"></i>
                {{ lang.filter }}
            </WarningButton>
            <PrimaryButton>
                <i class="icon-plus2"></i>
                {{ lang.add }}
            </PrimaryButton>
        </template>

        <template #breadcrumb>
            <BreadcrumbItem icon="icon-user-tie" :title="lang.staffs"/>
        </template>

        <Card :title="lang.staffs">
            <Table>
                <tr>
                    <th width="5%">#</th>
                    <th v-text="lang.name"></th>
                    <th v-text="lang.username"></th>
                    <th v-text="lang.gender"></th>
                    <th v-text="lang.status"></th>
                    <th v-text="lang.action"></th>
                </tr>

                <template v-if="staffs.data.length > 0">
                    <tr v-for="staff in staffs.data">
                        <td>{{ index++ }}</td>
                        <td>{{ staff.name }}</td>
                        <td>{{ staff.username }}</td>
                        <td>{{ lang[staff.gender.toLowerCase()] }}</td>
                        <td>{{ staff.status_text }}</td>
                        <td>
                            <Action>
                                <EditAction :href="route('staff.edit',staff)"/>
                                <DeleteAction @change="index = staffs.from" :text="staff.name"
                                              :url="route('staff.destroy',staff)"/>
                            </Action>
                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td colspan="5">{{ lang.empty }}</td>
                    </tr>
                </template>
            </Table>
        </Card>
    </AppLayout>
</template>

<style scoped>

</style>