import { User } from "@/types/models/user";
import { Flash } from "@/types/flash";

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    lang: { [key: string]: string };
    flash: Flash;
};

export interface Menu {
    title: string;
    url: string;
    icon?: any;
    children?: Menu[];
    isActive?: boolean;
    disabled?: boolean;
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
