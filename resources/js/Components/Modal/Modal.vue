<script setup>
import {computed} from "vue";

const props = defineProps({
    size: {
        type: String,
        validator(value) {
            return ["lg", "sm", "md"].includes(value);
        },
    },
    center: Boolean,
    footer: Boolean,
    bg: String,
    title: String,
    id: String
});

const modalSize = computed(() => {
    return {
        sm: 'modal-sm',
        md: 'modal-md',
        lg: 'modal-lg',
    }[props.size]
});

const classDialog = [modalSize];

if (props.center) {
    classDialog.push('modal-dialog-centered')
}

if (props.show) {
    classDialog.push('show');
}

</script>

<template>
    <Teleport to="body">
        <div class="modal fade" tabindex="-1" :id="id">
            <div class="modal-dialog " :class="classDialog">
                <div class="modal-content">
                    <div class="modal-header" :class="bg">
                        <h6>
                            {{ title }}
                        </h6>
                        <button class="close" type="button" data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">
                        <slot/>
                    </div>

                    <div class="modal-footer" v-if="footer"></div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
