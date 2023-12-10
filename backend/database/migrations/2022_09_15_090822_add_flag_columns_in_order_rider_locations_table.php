<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagColumnsInOrderRiderLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_rider_locations', function (Blueprint $table) {
            $table->bigInteger('flags')->default(0)->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_rider_locations', function (Blueprint $table) {
            $table->dropColumn('flags');
        });
    }
}
