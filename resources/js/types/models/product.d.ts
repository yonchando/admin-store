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
    created_at: string;
    updated_at: string;
}

export interface Products extends Paginate<Product> {
    data: Product[];
}
