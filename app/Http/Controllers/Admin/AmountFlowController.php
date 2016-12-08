<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class AmountFlowController extends Controller
{
    //

    public function index(Request $request)
    {
        $uid = $request->input('uid', '');

        $model = DB::table('users as u')->join('amount_flows as f', 'f.uid', '=', 'u.uid');

        if($uid) {
            $model = $model->where('u.uid', $uid)->orderBy('f.id', 'desc');
        } else {
            $model = $model->orderBy('f.id', 'desc');
        }

        $data = $model->paginate(20);

        $data->each(function ($item, $key) {
            $item->fee     /= 100;
            $item->balance /= 100;
        });

        return view('admin.AmountFlow.index', ['data' => $data, 'uid' => $uid, 'tradeType' => config('custom.trade_type')]);
    }
}
