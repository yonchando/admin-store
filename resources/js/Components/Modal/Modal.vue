<script setup>
import {reactive, ref} from "vue";

const props = defineProps({
    size: {
        type: String,
        validator(value, props) {
            return ['lg', 'sm', 'md'].includes(value);
        }
    },
    center: Boolean,
    footer: Boolean,
    bg: String,
    title: String,
});

const dialog = reactive({
    'modal-dialog-centered': props.center,
    'modal-sm': props.size === 'sm',
    'modal-lg': props.size === 'lg',
    'modal-md': props.size === 'md',
});

</script>

<template>
    <div class="modal fade" :class="{show}" tabindex="-1">
        <div class="modal-dialog" :class="dialog">
            <div class="modal-content">
                <div class="modal-header" :class="bg">
                    <h6>
                        {{ title }}
                    </h6>
                    <button class="close" type="button"
                            data-dismiss="modal">&times;
                    </button>
                </div>

                <div class="modal-body">
                    <slot/>
                </div>

                <div class="modal-footer" v-if="footer">

                </div>
            </div>
        </div>
    </div>
</template>
