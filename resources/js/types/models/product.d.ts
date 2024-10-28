import { Paginate } from "@/types/paginate";
import { Category } from "@/types/models/category";

export interface Product {
    id: bigint;
    product_name: string;
    description: string;
    price: number;
    stock_qty: number;
    category?: Category;
    status: string;
    slug: string;
    created_at: string;
    updated_at: string;
}

export interface ProductStatus {
    active: string;
    inactive: string;
}

export interface Products extends Paginate<Product> {
    data: Product[];
}
