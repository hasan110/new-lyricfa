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
        Schema::create('sms_verifies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mobile_number');
            $table->string('area_code')->default('98');
            $table->string('type')->default('login');
            $table->string('code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_verifies');
    }
};
