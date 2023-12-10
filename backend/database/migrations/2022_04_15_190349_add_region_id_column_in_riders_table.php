<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionIdColumnInRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('riders', function (Blueprint $table) {
            $table->dropColumn('region_of_operation');
            $table->string('region_id')->nullable()->after('rider_id');
            $table->foreign('region_id')->references('region_id')->on('regions')->onDelete('cascade')->update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('riders', function (Blueprint $table) {
            $table->string('region_of_operation')->nullable()->after('vehicle_type');
            $table->dropForeign('riders_region_id_foreign');
            $table->dropColumn(['region_id']);
        });
    }
}
