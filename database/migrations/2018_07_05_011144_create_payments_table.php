<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->comment('支付code');
            $table->integer('user_id')->commnet('用户ID');
            $table->string('name')->comment('支付方式');
            $table->integer('fee')->comment('手续费');
            $table->decimal('amount')->comment('金额');
            $table->string('desc')->nullable()->comment('描述');
            $table->integer('order_id')->nullable()->comment('订单ID');
            $table->string('type')->commnet('订单类型');
            $table->tinyInteger('is_cod')->default(0)->comment('是否货到付款');
            $table->tinyInteger('is_online')->default(0)->commnet('是否在线支付');
            $table->tinyInteger('is_pay')->default(0)->commnet('是否已付款');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
