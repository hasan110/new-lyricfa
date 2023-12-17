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
        Schema::create('film_texts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('film_id')->unsigned();
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');

            $table->integer('priority')->nullable();
            $table->text('text_english')->nullable();
            $table->text('text_persian')->nullable();
            $table->string('start_end_time')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_texts');
    }
};
