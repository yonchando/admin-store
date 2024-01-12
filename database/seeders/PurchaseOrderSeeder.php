<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\PurchaseOrder;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseOrder::factory(2)->hasOrderItems(3)->create();
    }
}
