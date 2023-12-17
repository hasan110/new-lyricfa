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
        Schema::create('word_definition_examples', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('word_definition_id')->unsigned()->nullable();
            $table->foreign('word_definition_id')->references('id')->on('word_definitions')->onDelete('cascade');

            $table->string('phrase');
            $table->string('definition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_definition_examples');
    }
};
