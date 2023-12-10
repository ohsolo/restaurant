<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagsInRiderEjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rider_rejects', function (Blueprint $table) {
            $table->double('flags')->default(0)->after('rider_longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rider_rejects', function (Blueprint $table) {
            $table->dropColumn('flags');
        });
    }
}
