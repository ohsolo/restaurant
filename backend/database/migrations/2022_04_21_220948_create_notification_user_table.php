<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_users', function (Blueprint $table) {
            $table->id();
            $table->string('notification_user_id')->unique();
            $table->string('notification_id')->nullable();
            $table->foreign('notification_id')->references('notification_id')->on('notifications')->onDelete('cascade')->update('cascade');
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
        Schema::dropIfExists('notification_users');
    }
}
