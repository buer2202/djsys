<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\AmountFlow;

class WechatController extends Controller
{
    //
    public function memberCard(Request $request)
    {
        $uid = session('uid');

        $user = User::where('uid', $uid)->first();
        $user->uid += 1000000000;
        $user->balance /= 100;
        $user->total_recharge /= 100;
        $user->total_gift /= 100;
        $user->total_consume /= 100;

        $flow = AmountFlow::where('uid', $uid)->take(10)->orderBy('id', 'desc')->get();

        $flow->each(function ($item, $key) {
            $item->fee /= 100;
        });

        return view('home.wechat.membercard', ['user' => $user, 'flow' => $flow, 'tradeType' => config('custom.trade_type')]);
    }
}
