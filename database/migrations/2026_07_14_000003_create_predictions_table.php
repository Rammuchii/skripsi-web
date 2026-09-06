<?php

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
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->string('fruit');
            $table->decimal('confidence', 6, 2)->default(0);
            $table->decimal('weight', 10, 2)->default(0);
            $table->unsignedInteger('price_per_kg')->default(0);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
