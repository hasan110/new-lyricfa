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
        Schema::create('english_word_definitions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('english_word_id')->unsigned();
            $table->foreign('english_word_id')->references('id')->on('english_words')->onDelete('cascade');

            $table->string('word_type')->nullable();
            $table->string('pronunciation')->nullable();
            $table->text('definition')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('english_word_definitions');
    }
};
