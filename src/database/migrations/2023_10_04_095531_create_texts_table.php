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
        Schema::create('texts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('music_id')->unsigned();
            $table->foreign('music_id')->references('id')->on('musics')->onDelete('cascade');

            $table->integer('priority')->nullable();
            $table->text('text_english');
            $table->text('text_persian');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};
