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
            $table->string('cancel_ptr')->after('cancel_request')->nullable();
            $table->string('cancel_fee')->after('cancel_ptr')->nullable();
            $table->string('refund_amount')->after('cancel_fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_bookings', function (Blueprint $table) {
            $table->dropColumn('cancel_ptr');
            $table->dropColumn('cancel_fee');
            $table->dropColumn('refund_amount');
        });
    }
};
