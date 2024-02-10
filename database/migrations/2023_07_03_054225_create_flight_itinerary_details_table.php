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
        Schema::create('flight_itinerary_details', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->string('airline_pnr')->nullable();
            $table->string('arrival_airport')->nullable();
            $table->string('arrival_date_time')->nullable();
            $table->string('arrival_terminal')->nullable();
            $table->text('baggage')->nullable();
            $table->string('cabin_class')->nullable();
            $table->string('departure_airport')->nullable();
            $table->string('departure_date_time')->nullable();
            $table->string('departure_terminal')->nullable();
            $table->string('flight_number')->nullable();
            $table->string('item_rph')->nullable();
            $table->string('journey_duration')->nullable();
            $table->string('marketing_airline_code')->nullable();
            $table->string('number_in_party')->nullable();
            $table->string('operating_airline_code')->nullable();
            $table->string('res_book_desig_code')->nullable();
            $table->string('stop_quantity')->nullable();
            $table->timestamps();
        });
    }
   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_itinerary_details');
    }
};
