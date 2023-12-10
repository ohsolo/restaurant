<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transactions', function (Blueprint $table) {
        $table->id();
        $table->string('order_transaction_id')->unique();
        $table->string('transaction_id')->nullable();
        $table->string('order_id')->nullable();
        $table->double('amount')->nullable();
        $table->bigInteger('flags')->default(0);
        $table->timestamps();

        // Foreign keys
        $table->foreign('transaction_id')->references('transaction_id')->on('transactions')->onDelete('cascade');
        $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_transactions');
    }
}
