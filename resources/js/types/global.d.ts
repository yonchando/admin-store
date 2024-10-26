import { PageProps as InertiaPageProps } from "@inertiajs/core";
import { AxiosInstance } from "axios";
import { route as ziggyRoute } from "ziggy-js";
import { PageProps as AppPageProps } from "./";
import { __ } from "@/locale";

type LaravelRoutes = {
    [key: string]: { uri: string; methods: string[] };
};

declare global {
    interface Window {
        axios: AxiosInstance;
        __: __;
    }

    /* eslint-disable no-var */
    let route: typeof ziggyRoute;

    declare interface ZiggyLaravelRoutes extends LaravelRoutes {}
    declare function route(): Router;
    declare function route(
        name: keyof ZiggyLaravelRoutes,
        params?: InputParams,
        absolute?: boolean,
        customZiggy?: Config,
    ): string;
}

declare module "vue" {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module "@inertiajs/core" {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
