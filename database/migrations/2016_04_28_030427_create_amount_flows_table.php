<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmountFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amount_flows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->unsigned();
            $table->bigInteger('fee')->default(0);         // 金额
            $table->tinyInteger('trade_type');          // 类型：1.充值；2.奖励；3.消费
            $table->string('note', 100)->default('');   // 备注
            $table->string('remark', 100)->default('');   // 手工备注
            $table->bigInteger('balance')->default(0);     // 余额
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('amount_flows');
    }
}
