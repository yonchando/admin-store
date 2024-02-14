<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\PurchaseOrder;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchaseOrders = PurchaseOrder::factory(5)->hasOrderItems(5);
        Customer::factory(100)->has($purchaseOrders)->create();
    }
}
