@extends('admin/layout')

@section('content')
<div class="container">
    <div class="alert alert-success" role="alert">
        <dl class="dl-horizontal">
            <dt>总用户数：</dt>
            <dd>{{ $data->count_all }}</dd>

            <dt>有余额的用户数：</dt>
            <dd>{{ $data->count_balance_left }}</dd>

            <dt>总余额：</dt>
            <dd>{{ $data->balance }}</dd>

            <dt>总充值金额：</dt>
            <dd>{{ $data->total_recharge }}</dd>

            <dt>总赠送金额：</dt>
            <dd>{{ $data->total_gift }}</dd>

            <dt>总消费金额：</dt>
            <dd>{{ $data->total_consume }}</dd>
        </dl>
    </div>
</div>
@endsection