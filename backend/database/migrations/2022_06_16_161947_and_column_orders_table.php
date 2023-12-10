<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;

class AndColumnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method',[
                Order::PAYMENT_ONLINE,
                Order::PAYMENT_CASH_ON_DELIVERY,
            ])->default(Order::PAYMENT_ONLINE)->after('order_method');
            $table->double('rider_return_fee')->default(0)->after('delivery_charges');
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
            $table->dropColumn(['rider_return_fee', 'payment_method']);
            
        });
    }
}
