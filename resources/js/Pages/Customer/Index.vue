<script setup>
import {Head} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card/Card.vue";
import Table from "@/Components/Table/Table.vue";
import {Link} from "@inertiajs/vue3";

const {lang, customers} = defineProps(['lang', 'customers'])

let index = customers.from;

</script>

<template>
    <Head :title="lang.customers"/>

    <AppLayout>
        <Card :title="lang.customers">
            <Table>
                <tr>
                    <th width="5%">#</th>
                    <th v-text="lang.name"></th>
                    <th v-text="lang.phone"></th>
                    <th v-text="lang.email"></th>
                    <th v-text="lang.gender"></th>
                </tr>

                <template v-if="customers.data.length > 0">
                    <tr v-for="customer in customers.data">
                        <td>{{ index++ }}</td>
                        <td>
                            <Link :href="route('customer.show',customer)">
                                {{ customer.name }}
                            </Link>
                        </td>
                        <td v-text="customer.phone"></td>
                        <td v-text="customer.email"></td>
                        <td v-text="customer.gender_text"></td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td>{{ lang.empty }}</td>
                    </tr>
                </template>
            </Table>
        </Card>
    </AppLayout>
</template>

<style scoped>

</style>