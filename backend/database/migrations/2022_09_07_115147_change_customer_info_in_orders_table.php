<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCustomerInfoInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('customer_info');
            $table->string('customer_name')->nullable()->after('address_id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->text('customer_other_info')->nullable()->after('customer_phone');
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
            $table->dropColumn(['customer_name', 'customer_phone', 'customer_other_info']);
            $table->string('customer_info')->nullable()->after('address_id');
        });
    }
}
