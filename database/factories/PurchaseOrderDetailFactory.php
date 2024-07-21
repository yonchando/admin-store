<?php

namespace Database\Factories;

use App\Casts\PurchaseDetail\ImageCast;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Traits\ImageProperty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<PurchaseOrderDetail>
 */
class PurchaseOrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = $this->faker->numberBetween(1, 10);
        $product_price = $this->faker->randomFloat(2, 10, 100);
        $product = Product::factory()->category()->create();

        $file = UploadedFile::fake()->image('image.png');
        $path = $file->hashName(config('paths.product_image'));

        $image = new ImageCast();
        $image->filename = $file->hashName();
        $image->path = $path;
        $image->url = Storage::fake()->url($path);
        $image->extension = $file->extension();
        $image->originalName = $file->getClientOriginalName();

        return [
            'purchase_order_id' => PurchaseOrder::factory(),
            'product_name' => $product->product_name,
            'category_name' => $product->category?->category_name,
            'price' => $product_price,
            'qty' => $qty,
            'total_price' => $product_price * $qty,
            'ref_product_id' => $product->id,
            'image' => $image
        ];
    }
}
