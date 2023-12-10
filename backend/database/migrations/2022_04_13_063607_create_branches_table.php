<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('branch_id')->unique();
            $table->string('rest_id')->nullable();
            $table->foreign('rest_id')->references('rest_id')->on('restaurants')->onDelete('cascade')->update('cascade');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('location')->nullable();
            $table->string('value')->nullable();
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
        Schema::dropIfExists('branches');
    }
}
