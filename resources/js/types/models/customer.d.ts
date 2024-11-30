export interface Customer {
    id: number;
    name: string;
    phone_number: string;
    country_code: string;
    phone: string;
    email: string;
    status: string;
    gender: string;
    birthday: string;
    profile: {
        filename: string;
        originalName: string;
        path: string;
        url: string;
        extension: string;
    };
    created_at: string;
    updated_at: string;
    deleted_at: string;
}
