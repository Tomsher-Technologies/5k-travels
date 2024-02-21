<?php

use App\Models\Airlines;
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
        Schema::create('yasin_flights', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Airlines::class);
            $table->string('route');
            $table->string('flight_no');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('arrival_date');
            $table->time('arrival_time');
            $table->string('status');
            $table->integer('adult_cap');
            $table->integer('child_cap');
            $table->integer('infant_cap');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yasin_flights');
    }
};
