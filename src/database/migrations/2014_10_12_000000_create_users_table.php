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
            $table->string('phone_number');
            $table->char('national_code' , 10)->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('birth_date')->nullable();
            $table->text('profile_picture')->nullable();
            $table->string('code_introduce')->nullable();
            $table->string('referral_code' , 45)->nullable();
            $table->text('api_token')->nullable();
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
