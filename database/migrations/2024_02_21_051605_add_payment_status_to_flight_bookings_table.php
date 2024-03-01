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
        Schema::table('flight_bookings', function (Blueprint $table) {
            $table->after('agents_amount', function ($table) {
                $table->string('payment_status')->nullable();
                $table->tinyText('payment_reference')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_reference'
            ]);
        });
    }
};
