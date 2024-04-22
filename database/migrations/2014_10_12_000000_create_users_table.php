<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->nullable();
            $table->unsignedInteger('user_pincode', 6)->nullable();
            $table->string('image')->nullable();
            $table->json('user_location');
            $table->integer('mobile')->unique();
            $table->string('password');
            $table->boolean('otp_status');
            $table->string('user_city');
            $table->string('rera_number');
            $table->rememberToken();
            $table->enum('role', ['admin', 'user'])->default('user');
            
            $table->string('payment_res')->nullable()->comment('Payment response');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending')->comment('Payment status: pending, completed, failed');

            $table->boolean('status')->default(true)->comment('1:Active,0:Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
