import { Permission } from "@/types/models/module";

export interface Role {
    id: number;
    code: string;
    name: string;
    status: string;
    status_text: string;
    permission_ids: { [key: number]: number[] };
    permissions: Permission[];
    created_at: string;
    updated_at: string;
}
