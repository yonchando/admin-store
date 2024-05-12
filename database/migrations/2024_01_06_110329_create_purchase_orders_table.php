<?php

use App\Enums\PurchaseOrder\PurchaseOrderStatus;
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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->double('total_price');
            $table->dateTime('purchased_at');
            $table->string('status')->default(PurchaseOrderStatus::PENDING->value);
            $table->timestamps();
        });

        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ref_product_id')->nullable();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->string('category_name')->nullable();
            $table->integer('qty');
            $table->decimal('price');
            $table->decimal('total_price');
            $table->jsonb('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
