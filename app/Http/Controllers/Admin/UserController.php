<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;

use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $uid = $request->input('uid', '');
        if($uid) {
            $model = User::where('uid', $uid)->orderBy('uid', 'desc');
        } else {
            $model = User::orderBy('uid', 'desc');
        }

        $data = $model->paginate(10);

        $data->each(function ($item, $key) {
            $item->balance /= 100;
        });

        return view('admin.User.index', ['data' => $data, 'uid' => $uid]);
    }

    // 充值
    public function recharge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'numeric|max:1000000',
            'gift'   => 'numeric|max:1000000',
        ], [
            'amount.numeric' => '充值金额必须是数字',
            'gift.numeric'   => '赠送金额必须是数字',
            'amount.max'     => '充值金额不能超过1000000',
            'gift.max'       => '赠送金额不能超过1000000',
        ]);

        if ($validator->fails()) {
            $msg = $validator->errors()->first();

            return response()->json(['info' => $msg, 'status' => 0]);
        }

        $uid = $request->input('uid');
        $amount = $request->input('amount', 0);
        $gift = $request->input('gift', 0);
        $remark = $request->input('remark', '');

        $result = User::recharge($uid, $amount, $gift, $remark);
        return response()->json($result);
    }

    // 消费
    public function consume(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'numeric|max:1000000',
        ], [
            'amount.numeric' => '充值金额必须是数字',
            'amount.max'     => '充值金额不能超过1000000',
        ]);

        if ($validator->fails()) {
            $msg = $validator->errors()->first();

            return response()->json(['info' => $msg, 'status' => 0]);
        }

        $uid = $request->input('uid');
        $amount = $request->input('amount', 0);
        $remark = $request->input('remark', '');

        $result = User::consume($uid, $amount, $remark);
        return response()->json($result);
    }

    // 详情
    public function info(Request $request)
    {
        $uid = $request->input('uid');

        $result = User::where('uid', $uid)->first();

        $result->balance        /= 100;
        $result->total_recharge /= 100;
        $result->total_gift     /= 100;
        $result->total_consume  /= 100;

        if($result) {
            return response()->json(['info' => $result, 'status' => 1]);
        } else {
            return response()->json(['info' => '用户信息获取失败', 'status' => 0]);
        }
    }
}
