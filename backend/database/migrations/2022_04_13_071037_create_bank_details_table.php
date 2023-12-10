<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();
            $table->string('bank_detail_id')->unique();
            $table->string('rider_id')->nullable();
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade');
            $table->string('rest_id')->nullable();
            $table->foreign('rest_id')->references('rest_id')->on('restaurants')->onDelete('cascade')->update('cascade');
            $table->string('bank')->nullable();
            $table->string('agency')->nullable();
            $table->integer('agency_verification_code')->default(0);
            $table->string('account')->nullable();
            $table->integer('account_verification_code')->default(0);
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
        Schema::dropIfExists('bank_details');
    }
}
