import { User } from "@/types/models/user";

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    lang: Object<string, string>;
};
