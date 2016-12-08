<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

use App\Admin;

class AdminController extends Controller
{
    /**
     * 处理登录认证
     *
     * @return Response
     */
    public function checklogin(Request $request)
    {
        // 获取密码
        $admin = Admin::where('name', $request->input('name'))->first();

        if(!$admin) {
            return redirect('/login')->withErrors(['name' => '用户名错误'])->withInput();
        }

        if(pwdEncrypt($request->input('password')) != $admin->password) {
            return redirect('/login')->withErrors(['password' => '密码错误'])->withInput();
        }

        session(['admin' => $admin->name]);

        return redirect('/admin/user');
    }


    // 更新密码
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpwd' => 'required',
            'pwd'    => 'required',
            'repwd'  => 'required|same:pwd',
        ], [
            'oldpwd.required' => '原密码不能为空',
            'pwd.required'    => '新密码不能为空',
            'repwd.required'  => '重复密码不能为空',
            'repwd.same'      => '两次密码不一致',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/chpwd')->withErrors($validator)->withInput();
        }

        $admin = Admin::where('name', session('admin'))->first();

        if(pwdEncrypt($request->input('oldpwd')) != $admin->password) {
            return redirect('/admin/chpwd')->withErrors(['oldpwd' => '原始密码错误'])->withInput();
        }

        Admin::where('id', $admin->id)->update(['password' => pwdEncrypt($request->input('pwd'))]);

        return redirect('/admin/chpwd')->with('status', '密码修改成功');
    }
}
