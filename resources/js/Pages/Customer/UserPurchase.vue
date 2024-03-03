<script setup>

import {Link, usePage} from "@inertiajs/vue3";


const lang = usePage().props.lang;

defineProps({
    data: Object
})

</script>

<template>
    <Table>
        <tr>
            <th>#</th>
            <th>{{ lang.name }}</th>
            <th>{{ lang.card_number }}</th>
            <th>{{ lang.expiry_date }}</th>
            <th>{{ lang.purchased_date }}</th>
            <th>{{ lang.status }}</th>
        </tr>

        <template v-if="data.length > 0">
            <tr v-for="(value,i) in data" :key="value.id">
                <td>{{ i + 1 }}</td>
                <td>
                    <Link :href="route('purchase.order.show',value)">
                        #{{ value.transaction_id }}
                    </Link>
                </td>
                <td>{{ value.total_price }} USD</td>
                <td>{{ value.order_items_count }}</td>
                <td>{{ value.purchased_date }} USD</td>
                <td v-html="value.status_text"></td>
            </tr>
        </template>
    </Table>
</template>

<style scoped>

</style>
