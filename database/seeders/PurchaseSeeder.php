<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
        ]);
        Customer::factory(10)->active()->create();
        Product::factory(10)->create();

        Purchase::factory(50)->create()->each(function ($purchase) {
            $details = PurchaseDetail::factory(fake()->numberBetween(1, 9))->create([
                'purchase_id' => $purchase->id,
            ]);

            $purchase->total = $details->sum('sub_total');
            $purchase->save();
        });
    }
}
