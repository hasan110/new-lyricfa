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
        Schema::create('word_definitions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('word_id')->unsigned();
            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');

            $table->text('definition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_definitions');
    }
};
