import { Paginate } from "@/types/paginate";
import User from "@/types/models/user";

export interface CategorySortable {
    category_name?: null | "asc" | "desc";
    created_at?: null | "asc" | "desc";
    updated_at?: null | "asc" | "desc";
}

export interface Category {
    id: number;
    category_name: string;
    parent_id: number;
    children_count: number;
    children: Category[] | [];
    creator: User | null;
    created_at: string;
    updated_at: string;
    open: boolean;
}

export interface Categories extends Paginate<Category> {}
