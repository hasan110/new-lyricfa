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
        Schema::create('playlist_music', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('music_id')->unsigned();
            $table->foreign('music_id')->references('id')->on('musics')->onDelete('cascade');

            $table->bigInteger('playlist_id')->unsigned();
            $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_music');
    }
};
