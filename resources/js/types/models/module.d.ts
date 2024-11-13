export interface Permission {
    id: number;
    code: string;
    name: string;
    created_at: string;
    updated_at: string;
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
