<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressIdInOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('address_id')->nullable()->after('rider_id');
            $table->foreign('address_id')->references('address_id')->on('addresses')->onDelete('cascade')->update('cascade');
            $table->text('customer_info')->nullable()->after('address_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_address_id_foreign');
            $table->dropColumn(['address_id', 'customer_info']);
        });
    }
}
