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
                        <a href="/admin/user" class="btn btn-default" type="button">全部</a>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>会员卡号</th>
                <th>余额</th>
                <th>管理</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $val)
            <tr>
                <td>{{ $val->uid }}</td>
                <td>{{ $val->balance }}</td>
                <td>
                    <button class="btn btn-warning btn-xs recharge" data-uid="{{ $val->uid }}">充值</button>
                    <button class="btn btn-success btn-xs consume" data-uid="{{ $val->uid }}">消费</button>
                    <button type="button" class="btn btn-info btn-xs info" data-toggle="modal" data-target="#myModal" data-uid="{{ $val->uid }}">详情</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $data->appends(['uid' => $uid])->links() !!}
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">用户详情</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
<script>
$(function () {
    // 充值
    $(".recharge").click(function () {
        var amount = prompt('请输入充值金额：', 0);
        if(amount == null) return false;

        var gift = prompt('请输入赠送金额：', 0);
        if(gift == null) return false;

        var remark = prompt('请输入备注：', '');
        if(remark == null) return false;

        $.post("/admin/user/recharge", {
            uid: $(this).data("uid"),
            amount: amount,
            gift: gift,
            remark: remark,
            _token: "{{ csrf_token() }}",
        }, function (data) {
            if(data.status === 1) {
                alert('操作成功');
                window.location.reload();
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 消费
    $(".consume").click(function () {
        var amount = prompt('请输入消费金额：');
        if(amount == null) return false;

        var remark = prompt('请输入备注：', '');
        if(remark == null) return false;

        $.post("/admin/user/consume", {
            uid: $(this).data("uid"),
            amount: amount,
            remark: remark,
            _token: "{{ csrf_token() }}",
        }, function (data) {
            if(data.status === 1) {
                alert('操作成功');
                window.location.reload();
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 详情
    $(".info").click(function () {
        $.post("/admin/user/info", {
            uid: $(this).data("uid"),
            _token: "{{ csrf_token() }}",
        }, function (data) {
            if(data.status === 1) {
                var html = '<dl class="dl-horizontal">';
                html += '<dt>余额：</dt><dd>' + data.info.balance + '</dd>';
                html += '<dt>累计充值：</dt><dd>' + data.info.total_recharge + '</dd>';
                html += '<dt>累计奖励：</dt><dd>' + data.info.total_gift + '</dd>';
                html += '<dt>累计消费：</dt><dd>' + data.info.total_consume + '</dd>';
                html += '<dt>注册时间：</dt><dd>' + data.info.created_at + '</dd>';
                html += '<dt>最后更新时间：</dt><dd>' + data.info.updated_at + '</dd>';
                html += '</dl>';

                $("#myModal .modal-body").html(html);
            } else {
                alert(data.info);
            }
        }, "json");
    });
});
</script>
@endsection
