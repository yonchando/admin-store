<?php

use App\Enums\Product\ProductStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->longText('description');
            $table->decimal('price', 11)->nullable();
            $table->bigInteger('stock_qty')->default(0)->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->string('slug')->nullable();
            $table->tinyText('status')->default(ProductStatusEnum::ACTIVE->value);
            $table->json('json')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
