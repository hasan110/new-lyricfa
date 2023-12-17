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
        Schema::create('idiom_definitions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('idiom_id')->unsigned();
            $table->foreign('idiom_id')->references('id')->on('idioms')->onDelete('cascade');

            $table->text('definition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idiom_definitions');
    }
};
