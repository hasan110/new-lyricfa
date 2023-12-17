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
        Schema::create('musics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('persian_name');
            $table->integer('album_id')->nullable();
            $table->text('cat_musics')->nullable();
            $table->integer('degree')->default(0);
            $table->integer('music_video')->default(0);
            $table->integer('sync_video')->default(0);
            $table->string('type_video')->default('mp4');
            $table->bigInteger('views')->default(0);
            $table->integer('start_demo')->default(0);
            $table->integer('end_demo')->default(0);
            $table->boolean('is_free')->default(0);
            $table->boolean('is_close')->default(0);
            $table->boolean('is_user_request')->default(0);
            $table->date('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music');
    }
};
