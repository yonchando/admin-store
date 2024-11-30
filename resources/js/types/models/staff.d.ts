import { Role } from "@/types/models/role";
import { Permission } from "@/types/models/module";

export interface Staff {
    id: number;
    name: string;
    username: string;
    password: string;
    gender: string;
    profile: string;
    position: string;
    status: string;
    permission_id_by_module_keys: any;
    roles: Role[];
    permissions: Permission[];
}
