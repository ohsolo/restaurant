<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatUsersTable extends Migration
{
    public function up()
    {
        Schema::create('chat_users', function (Blueprint $table) {
            $table->id();
            $table->string('chat_user_id')->unique();
            $table->string('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade')->update('cascade');
            $table->string('admin_id')->nullable();
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('cascade')->update('cascade');
            $table->string('rest_id')->nullable();
            $table->foreign('rest_id')->references('rest_id')->on('restaurants')->onDelete('cascade')->update('cascade');
            $table->string('rider_id')->nullable();
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_users');
    }
}
