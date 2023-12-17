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
        Schema::create('sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_singer_music_album')->nullable();
            $table->text('ids')->nullable();
            $table->integer('type')->default(0);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('banner')->nullable();
            $table->boolean('show_it')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
