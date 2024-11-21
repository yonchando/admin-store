import { User } from "@/types/models/user";

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    lang: { [key: string]: string };
    flash: { success: string | object; info: string | object; warning: string | object; error: string | object };
};

export interface Menu {
    title: string;
    url: string;
    icon?: any;
    children?: Menu[];
    isActive?: boolean;
}

export interface UploadFile {
    name: string;
    type: string;
    size: string;
    url: string;
}

export interface Gender {
    id: string;
    name: string;
}
