import { Permission } from "@/types/models/module";

export interface Role {
    id: number;
    code: string;
    name: string;
    status: string;
    status_text: string;
    permission_id_by_module_keys: { [key: number]: number[] };
    permissions: Permission[];
    created_at: string;
    updated_at: string;
}
