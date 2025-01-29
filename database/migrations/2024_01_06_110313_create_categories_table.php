<?php

use App\Models\Staff;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->unique();
            $table->string('slug')->unique();
            $table->longText('json')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreignIdFor(Staff::class, 'created_by')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Staff::class, 'updated_by')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
