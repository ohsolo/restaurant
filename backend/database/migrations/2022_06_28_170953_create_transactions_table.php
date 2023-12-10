<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->string('request_by_admin_id')->nullable();
            $table->string('request_by_rider_id')->nullable();
            $table->double('amount')->nullable();
            $table->text('response')->nullable();
            $table->bigInteger('flags')->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('request_by_admin_id')->references('admin_id')->on('admins')->onDelete('cascade');
            $table->foreign('request_by_rider_id')->references('rider_id')->on('riders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
