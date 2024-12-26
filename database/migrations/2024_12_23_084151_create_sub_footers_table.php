<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubFootersTable extends Migration
{
    public function up()
    {
        Schema::create('sub_footers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_id')->constrained('footers')->onDelete('cascade'); // Foreign key ke tabel footers
            $table->string('name'); // Nama subfooter
            $table->string('link'); // Link untuk subfooter
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_footers');
    }
}