<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInLoginAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_attempts', function (Blueprint $table) {
            $table->double('latitude')->nullable()->after('access_expiry');
            $table->double('longitude')->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_attempts', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
}
