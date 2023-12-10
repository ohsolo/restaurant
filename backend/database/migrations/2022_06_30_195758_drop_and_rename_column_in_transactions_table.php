<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAndRenameColumnInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_request_by_admin_id_foreign');
            $table->dropForeign('transactions_request_by_rider_id_foreign');
            $table->dropColumn('request_by_admin_id');
            $table->dropColumn('request_by_rider_id');
            $table->string('rider_id')->after('transaction_id');
            // foreign key constraints
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_rider_id_foreign');
            $table->dropColumn('rider_id');
            $table->string('request_by_admin_id')->nullable();
            $table->string('request_by_rider_id')->nullable();
             // Foreign key constraints
             $table->foreign('request_by_admin_id')->references('admin_id')->on('admins')->onDelete('cascade');
             $table->foreign('request_by_rider_id')->references('rider_id')->on('riders')->onDelete('cascade');

        });
    }
}
