<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantRiderQuestionsRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_rider_questions_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('rating_id')->unique();
            $table->string('order_id')->nullable();
            $table->string('rest_id')->nullable();
            $table->string('rider_id')->nullable();
            $table->string('question')->nullable();
            $table->double('rating')->nullable();
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade')->update('cascade');
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade');   
            $table->foreign('rest_id')->references('rest_id')->on('restaurants')->onDelete('cascade')->update('cascade');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('restaurant_rider_questions_ratings');
    }
}
