<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->string('support_id')->unique();
            $table->string('support_question_id')->nullable();
            $table->string('rider_id')->nullable();
            $table->text('support_question')->nullable();
            $table->text('message')->nullable();
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
            // foreign key 
            $table->foreign('support_question_id')->references('support_question_id')->on('support_questions')->onDelete('cascade')->update('cascade');
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supports');
    }
}
