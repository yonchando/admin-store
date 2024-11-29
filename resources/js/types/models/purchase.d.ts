import { Customer } from "@/types/models/customer";
import { Product } from "@/types/models/product";

export interface Purchase {
    id: number;
    ref_no: string;
    customer_id: number;
    total: number;
    status: "pending" | "accepted" | "rejected" | "completed" | "cancel";
    purchased_at: string;
    created_at: string;
    updated_at: string;
    customer?: Customer;
    purchase_details_count?: number;
    purchase_details: PurchaseDetail[];
}

export interface PurchaseDetail {
    id: number;
    product_id: number;
    purchase_id: number;
    product_name: string;
    category_name?: string;
    qty: number;
    price: string;
    sub_total: number;
    json?: object;
}

export interface PurchaseItem {
    id: number | null;
    product_id: number | null;
    qty: number;
    sub_total: number;
    product?: Product;
}
