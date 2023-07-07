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
        Schema::create('flight_margin_amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->integer("agent_id");
            $table->float('margin',5,2)->default(0);
            $table->double('amount')->default('0.00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_margin_amounts');
    }
};
