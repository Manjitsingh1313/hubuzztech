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
        Schema::create('reviews', function (Blueprint $table) {
         $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dealer_id');
            $table->text('comment');
            $table->timestamps();
            // Add foreign key constraints
            $table->foreign('user_id')->references('_id')->on('users');
            $table->foreign('dealer_id')->references('_id')->on('users');
            $table->boolean('status')->default(true)->comment('1:Active,0:Inactive');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
