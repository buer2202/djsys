@extends('home/layout')

@section('content')
<div class="container">
    <p></p>
    <div class="panel panel-primary">
        <div class="panel-heading">我的会员卡</div>
        <div class="panel-body">
            <p>会员卡号：{{ $user->uid }}</p>
            <p>当前余额：{{ $user->balance }}元</p>
            <p>累计充值：{{ $user->total_recharge }}元</p>
            <p>累计赠送：{{ $user->total_gift }}元</p>
            <p>累计消费：{{ $user->total_consume }}元</p>
        </div>

        @if (count($flow))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="4">近期交易概况</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($flow as $value)
                <tr>
                    <td>{{ substr($value->created_at, 0, 16) }}</td>
                    <td>{{ $tradeType[$value->trade_type] }}</td>
                    <td>{{ $value->fee }}</td>
                    <td>{{ mb_substr($value->remark, 0, 5) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
