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
        Schema::create('contact_elitechs', function (Blueprint $table) {
            $table->id();
            $table->json('whatsapp_number')->nullable();
            $table->json('phone_number')->nullable();
            $table->json('email')->nullable();
            $table->json('instagram')->nullable();
            $table->json('youtube')->nullable();
            $table->json('address')->nullable();
            $table->json('link_maps')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_elitechs');
    }
};
