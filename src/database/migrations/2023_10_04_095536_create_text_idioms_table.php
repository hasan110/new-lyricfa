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
        Schema::create('text_idioms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('text_id')->unsigned();
            $table->foreign('text_id')->references('id')->on('texts')->onDelete('cascade');

            $table->bigInteger('idiom_id')->unsigned();
            $table->foreign('idiom_id')->references('id')->on('idioms')->onDelete('cascade');

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_idioms');
    }
};
