<?php

use App\Enums\Customer\CustomerStatusEnum;
use App\Enums\GenderEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('phone', 13)->unique();
            $table->string('email', 100)->unique()->nullable();
            $table->string('password', 100);
            $table->enum('gender', [GenderEnum::MALE->value, GenderEnum::FEMALE->value])->nullable();
            $table->json('image')->nullable();
            $table->string('status')->default(CustomerStatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
