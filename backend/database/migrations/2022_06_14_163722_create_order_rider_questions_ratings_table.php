<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRiderQuestionsRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_rider_questions_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('order_rider_questions_rating_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('rider_id')->nullable();
            $table->string('question')->nullable();
            $table->double('rating')->nullable();
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade')->update('cascade');
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_rider_questions_ratings');
    }
}
