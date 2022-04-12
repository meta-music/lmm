<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\OfficialAccount\Application;

class OfficialController extends Controller
{
    use MyActions;

    /**
     * @var array
     */
    protected $app;

    protected $officialType = 'default';

    private $officialConfigs;

    public function __construct()
    {
        $this->officialConfigs = config('easywechat.official_account.default');
        $this->app = new Application($this->officialConfigs);
    }

    public function login()
    {
        $oauth = $this->app->getOauth();
        $user = $oauth->userFromCode(request()->get('code'));

//        dd($user);
        return $user->toArray();
    }

    public function ttt()
    {
        dd(request()->all());
    }

    public function wechat() {

        $server = app('easywechat.official_account')->getServer();

        $server->with(function($message){
            return "欢迎关注！";
        });

        return $server->serve();
    }

    public function uc()
    {
        return redirect(
            url('api/oauth/wechat/default/web?redirect_url='.
                url('api/oauth/wechat/default/web-notify')
            )
        );
    }

}
