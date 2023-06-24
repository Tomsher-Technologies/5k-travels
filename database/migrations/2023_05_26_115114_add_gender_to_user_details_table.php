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
        Schema::table('user_details', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->default('male')->after('last_name');
            $table->string('business_nature')->nullable()->comment('1 = Corporate, 2 = Destination Management Company, 3 = Tour Operator, 4 = Travel Agent, 5 = Wholesale Travel Company')->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};
