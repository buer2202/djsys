@extends('admin/layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <form>
                <div class="input-group">
                    <input type="text" name="uid" class="form-control" placeholder="请输入会员卡号" value="{{ $uid }}" />
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">查询</button>
                        <a href="/admin/amountflow" class="btn btn-default" type="button">全部</a>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>流水号</th>
                <th>会员卡号</th>
                <th>金额</th>
                <th>类型</th>
                <th>当前余额</th>
                <th>时间</th>
                <th>操作</th>
                <th>备注</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $val)
            <tr>
                <td>{{ $val->id }}</td>
                <td>{{ $val->uid }}</td>
                <td>{{ $val->fee }}</td>
                <td>{{ $tradeType[$val->trade_type] }}</td>
                <td>{{ $val->balance }}</td>
                <td>{{ $val->created_at }}</td>
                <td>{{ $val->note }}</td>
                <td>{{ $val->remark }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $data->appends(['uid' => $uid])->links() !!}
</div>

@endsection
