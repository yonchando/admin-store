export interface Permission {
    id: number;
    code: string;
    name: string;
    created_at: string;
    updated_at: string;
    pivot?: {
        module_id: number;
        permission_id: number;
        role_id: number;
        user_id: number;
    };
}
export interface Module {
    id: number;
    name: string;
    status: string;
    status_text: string;
    created_at: string;
    updated_at: string;
    permissions?: Permission[];
}
