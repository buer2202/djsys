<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

class WechatWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(session('uid'))) {    // 如果没有登录
            if(!$request->has('code')) {    // 如果没有code
                $appid        = config('wechat.AppID');
                $state        = str_random(10);
                $redirect_uri = urlencode("http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");

                $url = 'https://open.weixin.qq.com/connect/oauth2/authorize'
                     . '?appid=' . $appid
                     . '&redirect_uri=' . $redirect_uri
                     . '&response_type=code'
                     . '&scope=snsapi_base'
                     . '&state=' . $state
                     . '#wechat_redirect';

                return redirect($url)->with('state', $state);
            }

            $code = $request->input('code');
            $state = $request->input('state');

            if($state != session('state')) {
                return redirect('/');
            }

            $json = $this->getWechatUser($code);
            $wechatUser = json_decode($json, true);

            $this->login($wechatUser['openid']);
        }

        return $next($request);
    }

    private function getWechatUser($code)
    {
        $appid     = config('wechat.AppID');
        $secret = config('wechat.AppSecret');

        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token'
             . '?appid=' . $appid
             . '&secret=' . $secret
             . '&code=' . $code
             . '&grant_type=authorization_code';

        return http_get($url);
    }

    private function login($openid)
    {
        $user = User::where('openid', $openid)->first();

        if(!$user) { // 如果没有注册则注册
            $uid = User::insertGetId(['openid' => $openid, 'created_at' => date('Y-m-d H:i:s')]);
        } else {
            $uid = $user->uid;
        }

        session(['uid' => $uid]);
    }
}
