<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_has_option_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_option_group_id');
            $table->unsignedBigInteger('product_id');
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_has_option_groups');
    }
};
