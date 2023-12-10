<?php

use App\Models\PendingInfo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_infos', function (Blueprint $table) {
            $table->id();
            $table->string('pending_info_id')->unique();
            $table->string('rider_id')->nullable();
            $table->string('bank_detail_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('cpf')->nullable();
            $table->string('bank')->nullable();
            $table->string('agency')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('account')->nullable();
            $table->text('comment')->nullable();
            $table->enum('status',
            [
                PendingInfo::STATUS_APPROVED,
                PendingInfo::STATUS_PENDING,
                PendingInfo::STATUS_REJECTED,
            ]
            )->default(PendingInfo::STATUS_PENDING);
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
            // foreign key constraints
            $table->foreign('rider_id')->references('rider_id')->on('riders')->onDelete('cascade')->update('cascade');
            $table->foreign('bank_detail_id')->references('bank_detail_id')->on('bank_details')->onDelete('cascade')->update('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_infos');
    }
}
