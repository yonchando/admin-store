<script setup>
import {Head} from "@inertiajs/vue3";

import Card from "@/Components/Card/Card.vue";

import {Link} from "@inertiajs/vue3";
import {computed} from "vue";
import Paginate from "@/Components/Paginate.vue";

const {lang, customers} = defineProps(["lang", "customers"]);

let index = computed(() => customers.from);
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
                    <tr v-for="(customer, i) in customers.data">
                        <td>{{ index + i }}</td>
                        <td>
                            <Link :href="route('customer.show', customer)">
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

            <Paginate :data="customers"/>
        </Card>
    </AppLayout>
</template>

<style scoped></style>
