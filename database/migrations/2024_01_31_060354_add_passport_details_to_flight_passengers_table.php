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
        Schema::table('flight_passengers', function (Blueprint $table) {
            $table->after('passenger_nationality', function ($table) {
                $table->string('passport_issue_country')->nullable();
                $table->string('passport_issue_date')->nullable();
                $table->string('passport_expiry_date')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_passengers', function (Blueprint $table) {
            $table->dropColumn([
                'passport_issue_country',
                'passport_issue_date',
                'passport_expiry_date',
            ]);
        });
    }
};
