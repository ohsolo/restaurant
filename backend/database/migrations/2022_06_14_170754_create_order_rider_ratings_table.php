<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRiderRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_rider_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('order_rider_rating_id');
            $table->string('order_id')->nullable();
            $table->string('rider_id')->nullable();
            $table->double('rating')->nullable();
            $table->text('comment')->nullable();
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
        // Drop Foreign Keys
        Schema::table('order_rider_ratings', function (Blueprint $table) {
            $table->dropForeign('order_rider_ratings_order_id_foreign');
            $table->dropForeign('order_rider_ratings_rider_id_foreign');
        });
        Schema::dropIfExists('order_rider_ratings');
    }
}
