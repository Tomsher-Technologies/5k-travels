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
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string('unique_booking_id');
            $table->string('client_ref');
            $table->string('fare_type');
            $table->string('origin');
            $table->string('destination');
            $table->string('customer_email');
            $table->string('phone_code');
            $table->string('customer_phone');
            $table->integer('adult_count')->default(0);
            $table->integer('child_count')->default(0);
            $table->integer('infant_count')->default(0);
            $table->string('booking_status')->nullable();
            $table->string('ticket_status')->nullable();
            $table->double('adult_amount')->default('0.00');
            $table->double('child_amount')->default('0.00');
            $table->double('infant_amount')->default('0.00');
            $table->double('total_amount')->default('0.00');
            $table->double('addon_amount')->default('0.00');
            $table->double('total_tax')->default('0.00');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_bookings');
    }
};
