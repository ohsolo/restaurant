<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantOccurrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_occurrences', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_occurrence_id');
            $table->string('rest_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('rider_id')->nullable();
            $table->text('reason')->nullable();
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
        // Drop Foreign Keys
        Schema::table('restaurant_occurrences', function (Blueprint $table) {
            $table->dropForeign('restaurant_occurrences_order_id_foreign');
            $table->dropForeign('restaurant_occurrences_rider_id_foreign');
            $table->dropForeign('restaurant_occurrences_rest_id_foreign');
        });
        Schema::dropIfExists('restaurant_occurrences');
    }
}
