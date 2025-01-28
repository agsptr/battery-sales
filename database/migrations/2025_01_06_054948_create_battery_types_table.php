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
        Schema::create('battery_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('type_id')->unique();
            $table->string('type_name');
            $table->foreignId('brand_id')->constrained('battery_brands');
            $table->foreignId('category_id')->constrained('battery_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battery_types');
    }
};
