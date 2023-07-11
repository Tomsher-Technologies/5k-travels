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
            $table->string('currency')->default('USD')->after('agent_id');
            $table->double('total_amount')->default('0.00')->after('currency');
            $table->double('usd_amount')->default('0.00')->after('total_amount');
            $table->double('usd_rate')->default('0.00')->after('usd_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_margin_amounts', function (Blueprint $table) {
            $table->dropColumn('currency');
            $table->dropColumn('total_amount');
            $table->dropColumn('usd_amount');
            $table->dropColumn('usd_rate');
        });
    }
};
