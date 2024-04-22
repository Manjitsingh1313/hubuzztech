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
        Schema::create('ratings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('_id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('dealer_id');
            $table->foreign('dealer_id')->references('_id')->on('users')->onDelete('cascade');
            $table->integer('rating');
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
        Schema::dropIfExists('ratings');
    }
};
