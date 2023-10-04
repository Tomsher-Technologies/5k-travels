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
        Schema::create('api_user_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('api_user_id')->unsigned();
            $table->foreign('api_user_id')->references('id')->on('api_users')->onDelete('cascade');
            $table->string('username');
            $table->string('password');
            $table->string('access');
            $table->boolean('is_active')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_user_details');
    }
};

