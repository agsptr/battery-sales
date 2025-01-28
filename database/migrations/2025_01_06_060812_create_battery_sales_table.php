<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('battery_sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_id')->unique();
            $table->date('sale_date');
            $table->foreignId('brand_id')->constrained('battery_brands');
            $table->foreignId('category_id')->constrained('battery_categories')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('battery_types');
            $table->string('battery_jenis');
            $table->integer('units_sold');
            $table->decimal('cost_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('profit', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('battery_sales');
    }
};
