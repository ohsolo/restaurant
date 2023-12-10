<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityIdColumnInBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->string('city_id')->nullable()->after('rest_id');
            $table->foreign('city_id')->references('city_id')->on('cities')->onDelete('cascade')->update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('city')->nullable()->after('rest_id');
            $table->dropForeign('branches_city_id_foreign');
            $table->dropColumn(['city_id']);
        });
    }
}
