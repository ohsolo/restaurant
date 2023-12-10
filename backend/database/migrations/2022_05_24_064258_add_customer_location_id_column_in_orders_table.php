<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerLocationIdColumnInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('dishes_info')->nullable()->after('require_return');
            $table->double('delivery_charges')->nullable()->after('total_amount');
            $table->double('total_distance')->nullable()->after('delivery_charges');
            $table->string('order_number')->nullable()->after('order_id');
            $table->enum('order_method', ['app', 'email', 'phone', 'whatsapp'])->nullable()->after('total_distance');
            $table->dropColumn(['colelct_time', 'region_location', 'origin', 'total_rating']);
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
            $table->dropColumn(['order_method', 'order_number', 'dishes_info', 'delivery_charges', 'total_distance']);
            $table->string('colelct_time')->nullable()->after('pickup_time');
            $table->string('region_location')->nullable()->after('pickup_time');
            $table->string('origin')->nullable()->after('pickup_time');
            $table->string('total_rating')->nullable()->after('pickup_time');
        });
    }
}
