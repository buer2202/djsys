<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

use App\AmountFlow;

class User extends Model
{
    protected $hidden = ['openid']; // 隐藏openid

    // 充值
    static public function recharge($uid, $amount, $gift, $remark)
    {
        $amount = $amount * 100;
        $gift = $gift * 100;

        $user = self::where('uid', '=', $uid)->first();

        if(empty($user)) {
            return ['info' => '该用户不存在', 'status' => 0];
        }

        if($amount + $gift <= 0) {
            return ['info' => '充值金额不正确', 'status' => 0];
        }

        DB::beginTransaction();

        if($amount > 0) {
            $dataInsert[] = [
                'uid'        => $uid,
                'fee'        => $amount,
                'trade_type' => 1,
                'note'       => '充值' . $amount / 100 . '元',
                'balance'    => $user->balance + $amount,
                'created_at' => date('Y-m-d H:i:s'),
                'remark'     => $remark,
            ];
        }

        if($gift > 0) {
            $dataInsert[] = [
                'uid'        => $uid,
                'fee'        => $gift,
                'trade_type' => 2,
                'note'       => '赠送' . $gift / 100 .'元',
                'balance'    => $user->balance + $amount + $gift,
                'created_at' => date('Y-m-d H:i:s'),
                'remark'     => $remark,
            ];
        }

        $result = AmountFlow::insert($dataInsert);
        if(!$result) {
            DB::rollBack();
            return ['info' => '数据库更新失败', 'status' => 0];
        }

        $result = self::where('uid', '=', $uid)->update([
            'balance'        => $user->balance + $amount + $gift,
            'total_recharge' => $user->total_recharge + $amount,
            'total_gift'     => $user->total_gift + $gift,
        ]);
        if(!$result) {
            DB::rollBack();
            return ['info' => '数据库更新失败', 'status' => 0];
        }

        DB::commit();
        return ['info' => '', 'status' => 1];
    }

    // 消费
    static public function consume($uid, $amount, $remark)
    {
        $amount = $amount * 100;

        $user = self::where('uid', '=', $uid)->first();

        if(empty($user)) {
            return ['info' => '该用户不存在', 'status' => 0];
        }

        if($amount <= 0) {
            return ['info' => '消费金额不正确', 'status' => 0];
        }

        if($user->balance < $amount) {
            return ['info' => '余额不足', 'status' => 0];
        }

        DB::beginTransaction();

        $result = AmountFlow::insert([
            'uid'        => $uid,
            'fee'        => -$amount,
            'trade_type' => 3,
            'note'       => '消费' . $amount / 100 . '元',
            'balance'    => $user->balance - $amount,
            'created_at' => date('Y-m-d H:i:s'),
            'remark'     => $remark,
        ]);

        if(!$result) {
            DB::rollBack();
            return ['info' => '数据库更新失败', 'status' => 0];
        }

        $result = self::where('uid', '=', $uid)->update([
            'balance'       => $user->balance - $amount,
            'total_consume' => $user->total_consume + $amount,
        ]);
        if(!$result) {
            DB::rollBack();
            return ['info' => '数据库更新失败', 'status' => 0];
        }

        DB::commit();
        return ['info' => '', 'status' => 1];
    }
}
