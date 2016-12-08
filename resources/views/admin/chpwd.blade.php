@extends('admin/layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">修改密码</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/changepassword') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('oldpwd') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">原密码：</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="oldpwd" value="{{ old('pwd') }}" />

                                @if ($errors->has('oldpwd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oldpwd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pwd') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">新密码：</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="pwd" value="{{ old('pwd') }}" />

                                @if ($errors->has('pwd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pwd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('repwd') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">重复新密码：</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="repwd" value="{{ old('repwd') }}" />

                                @if ($errors->has('repwd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('repwd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">提交</button>
                                @if (session('status'))
                                <div class="alert alert-success" role="alert" style="margin-top: 20px">{{ session('status') }}</div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
