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
        Schema::create('isi_sub_footers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_footer_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nama Isi Sub-footer
            $table->string('link'); // Link terkait dengan sub-footer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isi_sub_footers');
    }
};
