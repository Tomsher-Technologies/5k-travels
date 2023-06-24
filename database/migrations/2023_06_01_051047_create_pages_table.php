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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_type');
            $table->string('page_name',255);
            $table->text('page_title');
            $table->longText('page_description')->nullable();
            $table->string('image',255)->nullable();
            $table->string('image_alt')->nullable();
            $table->string('seo_url');
            $table->string('seo_title',255)->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_title',255)->nullable();
            $table->text('og_description')->nullable();
            $table->string('twitter_title',255)->nullable();
            $table->text('twitter_description')->nullable();
            $table->text('keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
