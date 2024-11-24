<script setup lang="ts">
import ButtonGroup from "@/Components/ButtonGroup.vue";
import { computed } from "vue";
import useAction from "@/services/action.service";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";

const props = defineProps<{
    view?: () => void;
    edit?: () => void;
    destroy?: () => void;
}>();

const actions = computed(() => {
    let { view, edit, remove } = useAction();

    let acts = [];

    if (props.view) {
        view.props.onClick = props.view;
        acts.push(view);
    }

    if (props.edit) {
        edit.props.onClick = props.edit;
        acts.push(edit);
    }

    if (props.destroy) {
        remove.props.onClick = props.destroy;
        acts.push(remove);
    }

    return acts;
});
</script>

<template>
    <ButtonGroup>
        <template v-for="action in actions">
            <component type="button" :is="action.component" size="xs" v-bind="action.props">
                <fa-icon v-if="action.icon" :icon="action.icon" />
                <span v-else>{{ action.label }}</span>
            </component>
        </template>
        <slot />
    </ButtonGroup>
</template>

<style scoped></style>
