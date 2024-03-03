<script setup>
import Card from "@/Components/Card/Card.vue";
import ListItem from "@/Components/List/ListItem.vue";
import Badge from "@/Components/Badge/Badge.vue";

defineProps(['card']);
</script>

<template>
    <Head :title="$lang.card"/>

    <AppLayout>
        <Card no-header>
            <div class="row">
                <div class="col-6">
                    <div class="tw-space-y-3">
                        <ListItem :label="$lang.name" :value="card.name"/>
                        <ListItem :label="$lang.status">
                            <Badge :value="card.status"/>
                        </ListItem>
                    </div>
                </div>
            </div>
        </Card>
    </AppLayout>
</template>
