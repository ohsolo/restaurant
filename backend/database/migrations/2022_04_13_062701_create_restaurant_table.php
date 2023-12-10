<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('rest_id')->unique();
            $table->string('title')->nullable();
            $table->string('social_reason')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('public_place')->nullable();
            $table->string('number')->nullable();
            $table->string('neighbourhood')->nullable();
            $table->string('cep')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('phones')->nullable();
            $table->string('logo')->nullable();
            $table->double('total_rating')->default(0);
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
