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
        Schema::create('music_singer', function (Blueprint $table) {
            $table->bigInteger('music_id')->unsigned();
            $table->foreign('music_id')->references('id')->on('musics')->onDelete('cascade');
            $table->bigInteger('singer_id')->unsigned();
            $table->foreign('singer_id')->references('id')->on('singers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_singer');
    }
};
