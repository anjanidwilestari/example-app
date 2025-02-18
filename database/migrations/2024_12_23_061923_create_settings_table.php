<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relasi ke tabel users
            $table->foreignId('selected_book_id')->nullable()->constrained('books')->onDelete('set null'); // Relasi ke books
            $table->json('selected_testimoni_ids')->nullable(); // Menyimpan 3 ID testimoni terpilih
            $table->json('selected_reason_ids')->nullable(); // Menyimpan 4 ID reason terpilih
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};