export interface Module {
    id: number;
    name: string;
    status: string;
    status_text: string;
    created_at: string;
    updated_at: string;
    permissions?: {
        id: string;
        code: string;
        name: string;
    }[];
}
