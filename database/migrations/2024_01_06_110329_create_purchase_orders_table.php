<?php

use App\Enums\Order\PurchaseStatusEnum;
use App\Models\Purchase;
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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->unique();
            $table->double('total');
            $table->string('status', 50)->default(PurchaseStatusEnum::PENDING->value);
            $table->timestamp('purchased_at');
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('category_name')->nullable();
            $table->integer('qty');
            $table->decimal('price', 11);
            $table->decimal('sub_total');
            $table->json('json')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreignIdFor(Purchase::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
        Schema::dropIfExists('purchases');
    }
};
