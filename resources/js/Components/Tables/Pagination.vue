<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import { faAngleDoubleLeft, faAngleDoubleRight } from "@fortawesome/free-solid-svg-icons";
import Button from "@/Components/Button.vue";
import { PaginateMeta } from "@/types/paginate";

defineProps<{
    paginate: PaginateMeta;
}>();

const emit = defineEmits(["page"]);

function changePage(url: string) {
    router.get(url);
    emit("page");
}
</script>

<template>
    <div class="flex items-center px-2 py-4">
        <template v-if="paginate?.total">
            <div class="flex gap-4">
                <p class="">
                    Total:
                    <span class="font-semibold">
                        {{ paginate.total }}
                    </span>
                </p>
                <p>
                    Showing:
                    <span class="font-semibold">
                        {{ paginate.current_page }} of
                        {{ paginate.last_page }}
                        pages
                    </span>
                </p>
            </div>

            <template v-if="paginate && paginate.links">
                <div class="ml-auto flex" v-if="paginate && paginate.links.length > 0">
                    <template v-for="(link, index) in paginate.links">
                        <template v-if="index == 0">
                            <Button
                                @click="changePage(link.url ?? '')"
                                :disabled="!link.url"
                                class="rounded-s-full border-r-0 !px-3">
                                <fa-icon class="mr-2" :icon="faAngleDoubleLeft"></fa-icon>
                                Previous
                            </Button>
                        </template>
                        <template v-if="index != 0 && index != paginate.links.length - 1">
                            <Button
                                v-if="link.url"
                                :severity="link.active ? 'info' : 'secondary'"
                                @click="changePage(link.url ?? '')"
                                class="rounded-none border-l-0">
                                {{ link.label }}
                            </Button>
                            <Button v-else class="rounded-none border-l-0" severity="secondary">
                                {{ link.label }}
                            </Button>
                        </template>
                        <template v-if="index == paginate?.links?.length - 1">
                            <Button
                                @click="changePage(link.url ?? '')"
                                :disabled="!link.url"
                                class="rounded-e-full border-l-0 !px-3">
                                Next
                                <fa-icon :icon="faAngleDoubleRight" class="ml-2"></fa-icon>
                            </Button>
                        </template>
                    </template>
                </div>
            </template>
        </template>
    </div>
</template>

<style scoped></style>
