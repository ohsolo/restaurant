<?php

use App\Models\RestaurantRefill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantRefillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_refills', function (Blueprint $table) {
            $table->id();
            $table->string('refill_id')->unique();
            $table->string('rest_id')->nullable();
            $table->bigInteger('payment_id')->unique();
            $table->string('payment_method')->nullable();
            $table->double('amount')->default(0);
            $table->enum('request_by',
            [
                RestaurantRefill::REQUESTED_BY_ADMIN,
                RestaurantRefill::REQUESTED_BY_RESTAURANT
            ]
            )->default(RestaurantRefill::REQUESTED_BY_ADMIN);
            $table->enum('status',
            [
                RestaurantRefill::STATUS_APPROVED,
                RestaurantRefill::STATUS_PENDING,
                RestaurantRefill::STATUS_REJECTED,
                RestaurantRefill::STATUS_IN_PROGRESS
            ]
            )->default(RestaurantRefill::STATUS_PENDING);
            $table->bigInteger('flags')->default(0);
            $table->timestamps();

            // foreign keys
            $table->foreign('rest_id')->references('rest_id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_refills');
    }
}
