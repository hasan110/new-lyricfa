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
        Schema::create('idiom_definition_examples', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('idiom_definition_id')->unsigned();
            $table->foreign('idiom_definition_id')->references('id')->on('idiom_definitions')->onDelete('cascade');

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
        Schema::dropIfExists('idiom_definition_examples');
    }
};
