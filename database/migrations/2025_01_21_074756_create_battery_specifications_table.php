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
        Schema::create('battery_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('battery_categories')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('battery_brands')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('battery_types')->onDelete('cascade');
            $table->string('battery_jenis');
            $table->decimal('cost_price', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battery_specifications');
    }
};
