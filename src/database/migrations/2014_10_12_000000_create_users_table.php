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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mobile_number');
            $table->string('area_code')->default('98');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('code_introduce')->nullable();
            $table->string('referral_code' , 45)->nullable();
            $table->text('fcm_refresh_token')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
