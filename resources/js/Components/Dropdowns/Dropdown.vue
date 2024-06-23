<script setup>
import PrimeDropdown from "primevue/dropdown";
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icons/Icon.vue";
</script>

<template>
    <prime-dropdown
        :pt="{
            root: 'dropdown',
            panel: 'dropdown-panel',
        }"
    >
        <template #option="slotProps">
            <slot name="option">
                <Link
                    :href="slotProps.option.href"
                    :method="slotProps.option.method"
                >
                    <Icon
                        v-if="slotProps.option.icon"
                        class="min-w-6"
                        :icon="slotProps.option.icon"
                    />
                    {{ slotProps.option.label }}
                </Link>
            </slot>
        </template>
        <template #value>
            <slot name="value" />
        </template>
    </prime-dropdown>
</template>
