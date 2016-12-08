<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class PlatformController extends Controller
{
    //
    public function index()
    {
        $data = DB::table('users')
            ->select(DB::raw('count(uid) as count_all, sum(balance) as balance, sum(total_recharge) as total_recharge, sum(total_gift) as total_gift, sum(total_consume) as total_consume'))
            ->first();

        $data->balance        /= 100;
        $data->total_recharge /= 100;
        $data->total_gift     /= 100;
        $data->total_consume  /= 100;

        $data->count_balance_left = DB::table('users')->where('balance', '>', 0)->count('uid');

        return view('admin.Platform.index', ['data' => $data]);
    }
}
