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
        Schema::create('payment', function (Blueprint $table) {
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->string('card_number', 16);
            $table->string('card_exp_month', 2);
            $table->string('card_exp_year', 4);
            $table->string('card_cvv', 4);
            $table->text('billing_address');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->date('date');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('status')->default(true)->comment('1:Active,0:Inactive');
            $table->timestamps();
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
        Schema::dropIfExists('payment');
    }
};
