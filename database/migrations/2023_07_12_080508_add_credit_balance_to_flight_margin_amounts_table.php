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
        Schema::table('flight_margin_amounts', function (Blueprint $table) {
            $table->double('credit_balance')->default('0.00')->after('usd_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_margin_amounts', function (Blueprint $table) {
            $table->dropColumn('credit_balance');
        });
    }
};
