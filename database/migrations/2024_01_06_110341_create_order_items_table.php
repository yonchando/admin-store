<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("purchase_order_id")->constrained()->onDelete('cascade');
            $table->string('image');
            $table->string("product_name");
            $table->double("category_name")->nullable();
            $table->double("product_price");
            $table->integer("qty");
            $table->double("total_price");
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
