<?php

use App\Enums\Card\CardStatus;
use App\Enums\Card\CardStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->string('number', 16)->unique();
            $table->string('expiry_date')->nullable();
            $table->integer('points_balance')->default(0);
            $table->decimal('cashback_balance', 11, 2)->default(0);
            $table->string('status')->default(CardStatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
