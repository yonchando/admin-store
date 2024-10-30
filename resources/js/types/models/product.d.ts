import { Paginate } from "@/types/paginate";
import { Category } from "@/types/models/category";

export interface Product {
    id: number;
    product_name: string;
    description: string;
    price: number;
    stock_qty: number;
    category?: Category;
    category_id?: number;
    status: string;
    status_text: string;
    slug: string;
    json: ProductJson;
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
