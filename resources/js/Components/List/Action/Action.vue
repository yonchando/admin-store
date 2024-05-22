<script setup>
import DropdownToggle from "@/Components/Dropdowns/DropdownToggle.vue";
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
</script>

<template>
    <Dropdown>
        <template #toggle>
            <DropdownToggle>
                <i class="icon-list2"></i>
            </DropdownToggle>
        </template>

        <slot />
    </Dropdown>
</template>

<style scoped></style>
