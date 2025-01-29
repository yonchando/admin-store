import { Paginate } from "@/types/paginate";
import { Category } from "@/types/models/category";
import { globalFilter } from "@/services/helper.service";

export interface Product {
    id: number;
    product_name: string;
    description: string;
    price: number;
    stock_qty: number;
    category?: Category;
    category_id?: number;
    status: string;
    slug: string;
    json?: ProductJson;
    image_url?: string;
    created_at: string;
    updated_at: string;
}

export interface ProductJson {
    image: {
        filename: string | null;
        originalName: string | null;
        path: string | null;
        url: string | null;
        extension: string | null;
    };
}

export interface ProductStatus {
    active: string;
    inactive: string;
}

export interface Products extends Paginate<Product> {
    data: Product[];
}

export interface ProductFilter {
    page?: number | null;
    perPage?: number | null;
    last_page?: string | null;
    sortBy?: {
        field?: "created_at";
        direction?: "desc";
    };
    search?: string | null;
    price?: null;
    status?: null;
    category?: null;
    includeIds?: number[];
    excludeIds?: number[];
}
