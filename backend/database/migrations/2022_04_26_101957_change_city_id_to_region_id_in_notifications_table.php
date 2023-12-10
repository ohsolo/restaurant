<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCityIdToRegionIdInNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('notifications_city_id_foreign');
            $table->dropColumn(['city_id']);
            $table->string('region_id')->nullable()->after('notification_id');
            $table->foreign('region_id')->references('region_id')->on('regions')->onDelete('cascade')->update('cascade');
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('notifications_region_id_foreign');
            $table->dropColumn(['region_id']);
            $table->string('city_id')->nullable()->after('notification_id');
            $table->foreign('city_id')->references('city_id')->on('cities')->onDelete('cascade')->update('cascade');
        });
    }
}