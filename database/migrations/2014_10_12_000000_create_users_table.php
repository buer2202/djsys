<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('uid')->unsigned();
            $table->string('openid')->default('');
            $table->bigInteger('balance')->default(0);         // 当前余额
            $table->bigInteger('total_recharge')->default(0);  // 累计充值
            $table->bigInteger('total_gift')->default(0);      // 累计赠送
            $table->bigInteger('total_consume')->default(0);   // 累计消费
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
        Schema::drop('users');
    }
}
