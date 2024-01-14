<script setup>

import DropdownToggle from "@/Components/Dropdown/DropdownToggle.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
</script>

<template>
    <Dropdown>
        <template #toggle>
            <DropdownToggle>
                <i class="icon-list2"></i>
            </DropdownToggle>
        </template>

        <slot/>
    </Dropdown>
</template>

<style scoped>

</style>