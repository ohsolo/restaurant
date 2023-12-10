<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRiderLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_rider_locations', function (Blueprint $table) {
            $table->id();
            $table->string('order_rider_location_id')->unique();
            $table->string('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade')->update('cascade');
            $table->string('rider_id')->nullable();
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade'); 
            $table->double('latitude')->default(0);
            $table->double('longitude')->default(0);
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
        Schema::dropIfExists('order_rider_locations');
    }
}
