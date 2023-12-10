<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancelOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_orders', function (Blueprint $table) {
            $table->id();
            $table->string('cancel_order_id')->unique();
            $table->string('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade')->update('cascade');
            $table->string('rider_id')->nullable();
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade');
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
        Schema::dropIfExists('cancel_orders');
    }
}
