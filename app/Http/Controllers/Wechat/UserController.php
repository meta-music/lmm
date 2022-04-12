<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    protected $app;

    protected $miniProgramType = 'default';

    private $miniProgramConfigs;

    public function __construct()
    {
        $this->miniProgramConfigs = config('wechat.mini_program');
        $this->app = Factory::miniProgram($this->miniProgramConfigs[$this->miniProgramType]);
    }

    public function contentSecurity($content)
    {
        return $this->app->content_security->checkText($content);
    }

    public function imageSecurity($path)
    {
        return $this->app->content_security->checkImage($path);
    }

    public function getMyInfo()
    {
        return auth('api')->user();
    }

    public function me(Request $request)
    {
        return $this->getMyInfo();
    }

    public function update(Request $request)
    {
//        \Log::info($request);
        $ebUser = $this->getMyInfo();
        if ($request->has('nickname')) {
            $ebUser->nickname = $request->get('nickname');
        }
        if ($request->has('avatar')) {
            $ebUser->avatar = $request->get('avatar');
        }
        if ($request->has('phone')) {
            $phone = ($request->get('phone'));
            if (is_array($phone)){
                $session = $this->app->auth->session($phone['code']);
                $decryptedData = $this->app->encryptor->decryptData($session['session_key'], $phone['iv'], $phone['encryptedData']);
//        \Log::info($decryptedData);
                $ebUser->account = $decryptedData['phoneNumber'];
                $phone = $decryptedData['phoneNumber'];
            }
            $ebUser->phone = $phone;
        }
        if ($ebUser->isDirty()){
            $ebUser->save();
        }
//        \Log::info($ebUser);
        return response()->json($ebUser);
    }

    public function points(Request $request)
    {
//        \Log::info($request);
        $ebUser = $this->getMyInfo();
        if ($request->has('nickname')) {
            $ebUser->nickname = $request->get('nickname');
        }
        if ($request->has('avatar')) {
            $ebUser->avatar = $request->get('avatar');
        }
        if ($request->has('phone')) {
            $phone = ($request->get('phone'));
            if (is_array($phone)){
                $session = $this->app->auth->session($phone['code']);
                $decryptedData = $this->app->encryptor->decryptData($session['session_key'], $phone['iv'], $phone['encryptedData']);
//        \Log::info($decryptedData);
                $ebUser->account = $decryptedData['phoneNumber'];
                $phone = $decryptedData['phoneNumber'];
            }
            $ebUser->phone = $phone;
        }
        if ($ebUser->isDirty()){
            $ebUser->save();
        }
//        \Log::info($ebUser);
        return response($ebUser);
    }

}
