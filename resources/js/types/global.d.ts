import { PageProps as InertiaPageProps } from "@inertiajs/core";
import { AxiosInstance } from "axios";
import { route as ziggyRoute } from "ziggy-js";
import { PageProps as AppPageProps } from "./";
import { __ } from "@/locale";
import get from "@/bootstrap";
import Cropper from "cropperjs";

declare global {
    interface Window {
        axios: AxiosInstance;
        get: get;
        Cropper: Cropper;
        __: __;
    }

    /* eslint-disable no-var */
    let route: typeof ziggyRoute;
    let __: __;
}

declare module "vue" {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
        __: __;
    }
}

declare module "@inertiajs/core" {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
