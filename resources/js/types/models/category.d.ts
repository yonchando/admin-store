import { Paginate } from "@/types/paginate";

export interface Category {
    id: bigint;
    category_name: string;
    created_at: string;
    updated_at: string;
}

export interface Categories extends Paginate<Category> {
    data: Category[];
}
