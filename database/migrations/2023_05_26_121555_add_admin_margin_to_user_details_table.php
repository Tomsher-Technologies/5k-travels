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
            $table->float('admin_margin',5,2)->default(0)->after('company_reg_no');
            $table->float('agent_margin',5,2)->default(0)->after('admin_margin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('admin_margin');
            $table->dropColumn('agent_margin');
        });
    }
};
