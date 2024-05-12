<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_option_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price_adjustment', 11, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('product_has_option_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_option_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });

        Schema::create('product_has_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_has_option_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_option_id')->constrained()->cascadeOnDelete();
            $table->decimal('price_adjustment', 11, 4)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_option_groups');
    }
};
