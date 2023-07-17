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
        Schema::create('flight_extra_services', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->integer('service_id');
            $table->string('type');
            $table->string('behavior');
            $table->string('description');
            $table->string('checkin_type');
            $table->string('currency')->default('USD');
            $table->double('service_amount')->default('0.00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_extra_services');
    }
};
