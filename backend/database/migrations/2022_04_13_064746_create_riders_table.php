<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->string('rider_id')->unique();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('cnh_image')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('region_of_operation')->nullable();
            $table->string('cpf')->nullable();
            $table->string('block_reason')->nullable();
            $table->string('approve_reason')->nullable();
            $table->double('total_rating')->default(0);
            $table->bigInteger('flags')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('riders');
    }
}
