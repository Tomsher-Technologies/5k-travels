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
        Schema::create('flight_passengers', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->string('passenger_type')->nullable();
            $table->string('passenger_first_name')->nullable();
            $table->string('passenger_last_name')->nullable();
            $table->string('passenger_title')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passenger_nationality')->nullable();
            $table->string('eticket_number')->nullable();
            $table->string('itemRPH')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_passengers');
    }
};
