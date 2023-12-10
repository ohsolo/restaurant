<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->double('gross_profit')->default(0)->after('delivery_charges');
            $table->double('net_profit')->default(0)->after('gross_profit');
            $table->double('rest_order_amount')->default(0)->after('net_profit');
            $table->double('platform_charges_to_rider')->default(0)->after('rest_order_amount');
            $table->double('platform_charges_to_restaurant')->default(0)->after('platform_charges_to_rider');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['gross_profit', 'net_profit', 'rest_order_amount', 'platform_charges_to_rider', 'platform_charges_to_restaurant']);
            
        });
    }
}
