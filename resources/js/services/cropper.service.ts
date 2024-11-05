import Button from "@/Components/Button.vue";
import { defineStore } from "pinia";

export const useCropper = defineStore("cropper", {
    state() {
        return {
            cropper: null as Cropper | null,
            action: {
                label: "Crop",
                severity: "primary",
                onClick: null as ((e: Event) => void) | null,
                disabled: false,
            },
            file: null as File | null,
        };
    },
    actions: {
        actions() {
            return {
                label: this.action.label,
                component: Button,
                props: {
                    severity: this.action.severity,
                    onClick: this.action.onClick,
                    disabled: this.action.disabled,
                },
            };
        },
        createCropper(el: HTMLImageElement, options: Cropper.Options<HTMLImageElement> = {}) {
            options = {
                aspectRatio: 16 / 9,
                minCropBoxHeight: 1080,
                minCropBoxWidth: 1280,
                dragMode: "move",
                background: false,
                rotatable: false,
                scalable: false,
                zoomable: false,
                movable: false,
                cropBoxResizable: false,
                ...options,
            };

            if (this.cropper) {
                this.remove();
            }

            this.cropper = new Cropper(el, options);

            this.cropper?.replace(el.src);
        },
        getBlob() {
            return new Promise((resolve) => {
                this.cropper?.getCroppedCanvas().toBlob((blob) => {
                    resolve(blob);
                });
            });
        },
        remove() {
            this.cropper?.destroy();
        },
    },
});
