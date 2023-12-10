<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('rest_id')->nullable();
            $table->foreign('rest_id')->references('rest_id')->on('restaurants')->onDelete('cascade')->update('cascade');
            $table->string('branch_id')->nullable();
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade')->update('cascade');
            $table->string('rider_id')->nullable();
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade');
            $table->string('pickup_time')->nullable();
            $table->string('colelct_time')->nullable();
            $table->string('output_time')->nullable();
            $table->string('region_location')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('origin')->nullable();
            $table->string('require_return')->nullable();
            $table->text('observations')->nullable();
            $table->text('remarks')->nullable();
            $table->text('compliments')->nullable();
            $table->text('comments')->nullable();
            $table->text('response')->nullable();
            $table->double('total_rating')->nullable();
            $table->bigInteger('flags')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
