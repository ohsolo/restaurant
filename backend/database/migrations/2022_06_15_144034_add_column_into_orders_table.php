<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
class AddColumnIntoOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status',[
                Order::STATUS_DELIVERED,
                Order::STATUS_REJECTED,
                Order::STATUS_RESEARCH,
                Order::STATUS_PENDING
            ])->default(Order::STATUS_PENDING)->after('response');
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
            
        });
    }
}
