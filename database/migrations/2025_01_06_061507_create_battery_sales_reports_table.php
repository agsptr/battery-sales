<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('battery_sales_reports', function (Blueprint $table) {
            $table->id();
            $table->string('time_id')->unique();
            $table->date('sale_date');
            $table->integer('week');
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('battery_sales_reports');
    }
};
