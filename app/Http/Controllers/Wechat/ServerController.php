<?php

namespace App\Http\Controllers\Wechat;

use EasyWeChat\Kernel\Exceptions\DecryptException;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use EasyWeChat\MiniProgram\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Models\Wechat\EbUser;
use App\Http\Controllers\Controller;
use App\Models\Wechat\EbWechatUser;

// use EasyWeChat\OfficialAccount\Application; // todo 多个公众号不能用依赖注入【需要设置default公众号】
// use App\User;

class ServerController extends Controller
{
    use MyActions;
    /**
     * @var array
     */
    private $officialConfigs;

    public function __construct()
    {
        $this->officialConfigs = config('wechat.official_account');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $withUser = false)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
        if ($withUser){
            $data['user_info'] = auth('api')->user();
        }
        return response()->json($data);
    }

    /**
     * Jssdk
     *
     * @param \Illuminate\Http\Request $request
     * @param string $type
     * @return void
     */
    public function jssdk(Request $request, string $type='default')
    {
        $this->validate($request, ['jssdk_url' => 'url']);

        $official = Factory::officialAccount($this->officialConfigs[$type]);
        if ($request->jssdk_url) {
            $official->jssdk->setUrl($request->jssdk_url);
        }

        return response(json_decode($official->jssdk->buildConfig([])));
    }

    /**
     * 网页授权
     *
     * @param \Illuminate\Http\Request $request
     * @param string $type
     * @return void
     */
    public function web(Request $request, string $type='default')
    {
        $this->validate($request, ['redirect_url' => 'url']);

        $official = Factory::officialAccount($this->officialConfigs[$type]);
        if ($request->redirect_url) {
            $official->oauth->setRedirectUrl($request->redirect_url);
        }

        return $official->oauth->redirect();
    }

    /**
     * 网页授权的回调
     *
     * @param \Illuminate\Http\Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @author jfxia
     */
    public function webNotify(Request $request, string $type='default')//: JsonResponse
    {
        $official = Factory::officialAccount($this->officialConfigs[$type]);

        try {
            // 获取 OAuth 授权结果用户信息
            $user = $official->oauth->user();
//            \Log::info(json_encode($user));
            $wechatUserInfo = $user->getOriginal();
            $wechatUserInfo['web'] = 1;
            $user = $this->getUser($wechatUserInfo);
            $token = auth('api')->login($user);
            //todo redirect_url to payment or other url
//            if ($request->redirect_url) {
//                return redirect(route(''));
//            }
//            return redirect(route('official.index'));
        } catch (\Exception $exception) {
            return response([$exception->getMessage()],500);
        }
        $this->setMe(auth('api')->user());
        return $this->getIndex();
    }

    /**
     * 小程序登陆
     *
     * @param \Illuminate\Http\Request $request
     * @param \EasyWeChat\MiniProgram\Application $miniProgram
     * @return \Illuminate\Http\JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     * @throws \Exception
     * @author jfxia
     */
    public function miniProgramLogin(Request $request, Application $miniProgram)
    {
        if (!Arr::has($request->all(),['code','encryptData','iv'])){
            return response(['request参数错误',$request->all()], 422);
        }
        $auths = $miniProgram->auth->session($request->code);
        if (isset($auths['errcode'])) {
            return response($auths, 422);
        }
        try {
            $decryptedData = $miniProgram->encryptor->decryptData($auths['session_key'], $request->iv, $request->encryptData);
            return $this->respondWithToken(auth('api')->login($this->getUser($decryptedData)),true);
        } catch (DecryptException $exception) {
            \Log::error('小程序登陆解密失败：' . $exception->getTraceAsString());
            return response('Decrypt Error.' . $exception->getMessage(),500);
        } catch (\Exception $exception) {
            \Log::error($exception->getTraceAsString());
            return response('Service Error.' . $exception->getMessage(),500);
        }
    }

    public function getUser($request)
    {
        $unionId = $request['unionid'];
        $openId = $request['openid'];
        $nickName = $request['nickname'];
        $avatarUrl = $request['headimgurl'];
        if (! isset($unionId) || empty($unionId)) {
            return response('Decrypt Error.', 422);
        }
        $type = isset($request['web']) ? '' : 'routine_';
        $wechatUser = EbWechatUser::firstOrNew(['unionid' => $unionId]);
        if (($user = EbUser::where('unionid', $unionId)->first()) && $wechatUser->uid) {
            if (empty($wechatUser->{"{$type}openid"})) { //$wechatUser->{"{$type}openid"} != $openId
                $wechatUser->{"{$type}openid"} = $openId;
                $wechatUser->save();
            }
            if (empty($user->status)) {
                return response('你在小黑屋哦',422);
            }
        } else {
            if (empty($user)){
                $user = EbUser::create([
                    'account' => $unionId,
                    'pwd' => '$2y$10$ycZR1N2xPTL2cmCLpExpPuGGJfVvPC410R3C5P63FVAO5mJ5qFVte',
                    'nickname' => $nickName,
                    'avatar' => $avatarUrl,
                    'add_time' => Carbon::now()->timestamp,
                    'add_ip' => \request()->getClientIp(),
                    'last_time' => Carbon::now()->timestamp,
                    'last_ip' => \request()->getClientIp(),
                    'user_type' => 'wechat',
                    'unionid' => $unionId,
                ]);
            }
            $hasWechatUser = EbWechatUser::find($user->uid);
            if (!empty($hasWechatUser)) {
                $wechatUser = $hasWechatUser;
            }

            $wechatUser->uid = $user->uid;
            $wechatUser->nickname = $nickName;
            $wechatUser->sex = $request['gender']??$request['sex'];
            $wechatUser->language = $request['language'];
            $wechatUser->city = $request['city'];
            $wechatUser->province = $request['province'];
            $wechatUser->country = $request['country'];
            $wechatUser->headimgurl = $avatarUrl;
            $wechatUser->{"{$type}openid"} = $openId;
            $wechatUser->unionid = $unionId;
            $wechatUser->save();
        }
        return ($user);
    }
}
