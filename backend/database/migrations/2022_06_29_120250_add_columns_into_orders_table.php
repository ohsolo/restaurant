<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsIntoOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_cancel_question_id')
            ->nullable()->after('status');

            $table->text("order_cancel_question")
            ->nullable()
            ->after('order_cancel_question_id');

            $table->text("order_cancel_comment")
            ->nullable()
            ->after('order_cancel_question');

            // foreign key constraints
            $table->foreign('order_cancel_question_id')->references('order_cancel_question_id')->on('order_cancel_questions');
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
            $table->dropForeign('orders_order_cancel_question_id_foreign');
            $table->dropColumn(['order_cancel_question_id', 'order_cancel_question', 'order_cancel_comment']);
        });
    }
}
