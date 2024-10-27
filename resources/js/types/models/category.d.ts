import { Paginate } from "@/types/paginate";

export interface CategorySortable {
    category_name?: null | "asc" | "desc";
    created_at?: null | "asc" | "desc";
    updated_at?: null | "asc" | "desc";
}

export interface Category {
    id: number;
    category_name: string;
    created_at: string;
    updated_at: string;
}

export interface Categories extends Paginate<Category> {
    data: Category[];
}
