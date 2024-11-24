import { Customer } from "@/types/models/customer";

export interface Purchase {
    id: number;
    ref_no: string;
    customer_id: number;
    total: number;
    status: "pending" | "accepted" | "rejected" | "completed" | "cancel";
    created_at: string;
    updated_at: string;
    customer?: Customer;
    purchase_details_count?: number;
    purchase_details?: PurchaseDetail[];
}

export interface PurchaseDetail {
    id: number;
    ref_product_id: number;
    purchase_id: number;
    product_name: string;
    category_name?: string;
    qty: number;
    price: string;
    sub_total: string;
    json?: object;
}

export interface PurchaseItem {
    product_id: number | null;
    qty: number;
    sub_total: number;
}
