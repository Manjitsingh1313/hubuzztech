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
        Schema::create('properties', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('property_name');
            $table->decimal('price', 10, 2); 
            $table->json('location'); 
            $table->integer('bedrooms'); 
            $table->integer('bathrooms'); 
            $table->integer('area_sqft'); 
            $table->enum('deal', ['sale', 'rent']); 
            $table->enum('type', ['house', 'apartment', 'villa']); 
            $table->integer('parking'); 
            $table->text('description'); 
            $table->string('assigned_buyer')->nullable(); 
            $table->boolean('isAvailable')->default(true); 
            $table->string('dealer')->nullable(); 
            $table->integer('dealer_contact');
            $table->string('district')->nullable(); 
            $table->json('property_details'); 
            $table->string('images');
            $table->string('photo')->nullable(); 
            $table->timestamps(); 
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
        Schema::dropIfExists('properties');
    }
};
