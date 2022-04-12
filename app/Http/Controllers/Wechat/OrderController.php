<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Models\Wechat\WPayAction;
use App\Models\Wechat\WPayRefund;
use App\Http\Controllers\Controller;
use Todo\SLesson;
use Todo\SLessonUser;
use App\Models\Wechat\WUnifiedorder as Order;
use EasyWeChat\Factory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    /**
     * @var array
     */
    private $paymentConfigs;

    public function __construct()
    {
        $this->paymentConfigs = config('wechat.payment');
    }

    /**
     * 订单详情
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
//        $order->load('goods');
//
//        return response()item($order, OrderResource::class);
    }

    public function payRefundSubmit(Request $request, WPayRefund $payRefund, Order $order)
    {
        $orderId = $request->get('order_id');
        $reason = $request->get('reason');
        $hasOrder = $order->find($orderId);
        if (empty($hasOrder) || $hasOrder->trade_state<>'SUCCESS'){
            return \response(['当前订单未支付成功, 无法退款!'],422);
        }
        $newRefund = $payRefund->where('order_id',$orderId)
            ->where('created_at','>',Carbon::now()->addDays(-1))->first();
        if (empty($newRefund)) {
            try {
                // todo order 状态变更
//                DB::beginTransaction();
                $payRefund->create([
                    'order_id' => $orderId,
                    'reason' => $reason,
                    'out_trade_no' => $hasOrder->out_trade_no,
                ]);
//                $hasOrder->payaction->trade_state = 'refunding';
//                $hasOrder->payaction->trade_state_desc = '退款申请中';
//                $hasOrder->payaction->save();
//                DB::commit();
            } catch (\Exception $exception) {
//                DB::rollBack();
                Log::error($exception->getMessage());
                return \response([$exception->getMessage()],422);
            }
        }
        return \response(['退款申请完成, 客服将在24小时内处理!']);
    }

    public function userPaying(Request $request)
    {
        $package = $request->get('package');
        $order = Order::where('prepay_id',Str::after($package,'prepay_id='))->first();
        if (empty($order)){
            return \response('订单不存在','422');
        }
        $lessonUser = SLessonUser::where('order_id',$order->id)->update(['status'=>1]);
        if ($lessonUser>0){
            return \response('课程权限已临时更新');
        }
        return \response('无可更新课程权限');
    }

    /**
     * 生成课程订单
     *
     * @param StoreOrderPost $request
     * @param \Order $order
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     * @author jfxia
     */
    public function storeOrder(Request $request, Order $order, string $type='default')
    {
        $user = $request->user();
        $lessonIds = (array)$request->get('lessons');
        if (!$lessonIds){
            Log::error('课程链接无效，lessons参数为空');
            return response(['课程链接无效，请联系商家'],422);
        }
        $lessons = SLesson::whereIn('id',$lessonIds)->get(['id','title']);
        if (!$lessons){
            Log::error('课程已下架，无法购买，lessons不存在');
            return response(['课程已下架，无法购买，请联系商家'],422);
        }
        $lessonUser = SLessonUser::where('status','<>',0)->where('user_id',$user->uid)
            ->whereIn('s_lesson_id',$lessons->pluck('id'))->get(['s_lesson_id'])->pluck('s_lesson_id');
        // 支付前检查是否已购买改课程
        if (count($lessonUser)>0){
            Log::error('课程已激活，请不要重复购买!'.json_encode($lessonUser));
            return response(['课程已激活，请不要重复购买!',$lessons->whereIn('id',$lessonUser)],422);
        }
        $payment = Factory::payment($this->paymentConfigs[$type]);
        $typeOpenid = $type == 'default' ? '' : $type;
//        $user = $app->user->get($openId);
        $openId = $user->ebWechatUser->{"{$typeOpenid}openid"};
//        \Log::info($openId);
        if (!$openId) {

        }
        $total_fee = 1;//todo sum total fee by lesson or subject!
        $goodsDetail = [];
        foreach ($lessons as $lesson) {
            $goodsDetail[]['goods_id'] = $lesson->id;
            $goodsDetail[]['goods_name'] = $lesson->title;
            $goodsDetail[]['price'] = 1;
            $goodsDetail[]['quantity'] = 1;
            $goodsDetail[]['wxpay_goods_id'] = $lesson->id;
        }
        $detail['goods_detail'] = $goodsDetail;
        $detail['cost_price'] = $total_fee;
        $detail['receipt_id'] = '';
        try {
            DB::beginTransaction();
            $order->user_id = $user->uid;
            $order->appid = $this->paymentConfigs[$type]['app_id']; // '公众账号ID',
            $order->mch_id = $this->paymentConfigs[$type]['mch_id']; // '商户号',
            $order->device_info = $type; // '设备号',
            $order->body = '购买课程『' .
                implode('』,『',$lessons->pluck('title')->toArray())
                . '』'; // '商品描述',
            $order->detail = json_encode($detail); // '商品详情',
            $order->attach = $request->server('HTTP_USER_AGENT'); // '附加数据',
            $order->out_trade_no = date('YmdHis') . substr(uniqid(), -3) . $user->uid; // '商户订单号',
            $order->fee_type = 'CNY'; // '标价币种',
            $order->total_fee = $total_fee; // '标价金额',
            $order->spbill_create_ip = $request->getClientIp(); // '终端IP',
            $order->trade_type = 'JSAPI'; // '交易类型',
            $order->openid = $openId; // '用户标识',
//            $order->product_id = '1'; // '商品ID',
//            $order->sign = ''; // '签名',
//            $order->sign_type = ''; // '签名类型',
//            $order->time_start = ''; // '交易起始时间',
//            $order->time_expire = ''; // '交易结束时间',
//            $order->goods_tag = ''; // '订单优惠标记',
//            $order->notify_url = $order->notify_url; // '通知地址',
//            $order->limit_pay = ''; // '指定支付方式',
//            $order->receipt = ''; // '电子发票入口开放标识',
//            $order->scene_info = ''; // '-场景信息',
            $payRequest = [
                'body'         => $order->body,
                'out_trade_no' => $order->out_trade_no,
                'total_fee'    => $order->total_fee,
                'trade_type'   => $order->trade_type,
                'openid'       => $order->openid,
                'notify_url'   => route('payment.notify', $type)
            ];
//            return response([
//                'login_status' => $user,//auth('api')->login($user)
//                'order' => $payRequest,
//            ]);
            $result = $payment->order->unify($payRequest);
            $order->return_code = $result['return_code']; // '返回状态码',
            $order->return_msg = $result['return_msg']; // '返回信息',
            if (isset($result['return_code']) && $result['return_code'] === 'SUCCESS' &&
                isset($result['result_code']) && $result['result_code'] === 'SUCCESS' && isset($result['prepay_id'])) {
                $order->result_code = $result['result_code']; // '业务结果',
                $order->prepay_id = $result['prepay_id']; // '预支付交易会话标识',
                $order->nonce_str = $result['nonce_str']; // '随机字符串',
//              $order->code_url = $result['code_url']; // '二维码链接', //todo 二维码场景判断
                if ($order->save()) {
                    foreach ($lessons as $lesson) {
                        SLessonUser::create([
                            'user_id'=>$order->user_id,
                            'order_id'=>$order->id,
                            's_lesson_id' => $lesson->id,
                            'status' => 0,
                        ]);
                    }
                } else {
                    DB::rollBack();
                    Log::error('Order Model Save Error.');
                    return response(['Order Model Save Error.'],422);
                }
            } else {
                $order->result_code = isset($result['result_code']) ?? $result['result_code']; // '业务结果',
                $order->err_code = isset($result['err_code']) ?? $result['err_code']; // '错误代码',
                $order->err_code_des = isset($result['err_code_des']) ?? $result['err_code_des']; // '错误代码描述',
                $order->save();
                Log::error($result);
                return response($result,422);
            }
            DB::commit();
            // return "appId","timeStamp","nonceStr","package","signType","paySign"
            $payJssdk = $payment->jssdk->bridgeConfig($order->prepay_id);
        } catch (\Exception $exception) {
            //dd($exception->getTraceAsString()); // todo 还有其它异常后面补上
            DB::rollBack();
            Log::error($exception->getMessage());
            return response([$exception->getMessage()],500);
        }

        if ($request->get('test')) {
            echo '<div align="center"><button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="onBridgeReady()" >立即支付</button></div>
                <script>
                function onBridgeReady(){
                    WeixinJSBridge.invoke(\'getBrandWCPayRequest\', '.($payJssdk).',
                    function(res){if(res.err_msg == "get_brand_wcpay_request:ok" ){}});
                }
                if (typeof WeixinJSBridge == "undefined"){
                    if( document.addEventListener ){
                        document.addEventListener(\'WeixinJSBridgeReady\', onBridgeReady, false);
                    }else if (document.attachEvent){
                        document.attachEvent(\'WeixinJSBridgeReady\', onBridgeReady);
                        document.attachEvent(\'onWeixinJSBridgeReady\', onBridgeReady);
                    }
                }else{
                    onBridgeReady();
                }
                </script>';
            dd($user,$result,json_decode($payJssdk));
        }
        return response([
            'pay_jssdk' => json_decode($payJssdk),
            'login_status' => $user,//auth('api')->login($user)
            'order' => $payRequest,
        ]);
    }

    /**
     * 微信支付回调
     *
     * @param string $type
     * @return void
     */
    public function paymentNotify(string $type='default') // todo 对Order模型产生依赖，把Order放到外面？
    {
        $payment = Factory::payment($this->paymentConfigs[$type]);
        $response = $payment->handlePaidNotify(function ($message, $fail) use ($payment) {
            // 1. 根据out_trade_no确认订单是否存在
            $order = Order::where('out_trade_no', $message['out_trade_no'])->first();
            if (empty($order)) {
                \Log::error('Order not exist',$message, $order);
                return $fail('Order not exist.');;
            }
            $message['order_id']=$order->id;
            // 2. 根据order_id 查看订单支付状态是否完成
            $payAction = WPayAction::find($order->id);
            if (!empty($payAction) && $payAction->result_code === 'SUCCESS') {
                return true; // 告诉微信，我已经处理完了，已经支付成功了，别再通知我了
            }
            /////////////建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            // $payment->order->queryByOutTradeNumber($message['out_trade_no']);
            $query = $payment->order->queryByTransactionId($message['transaction_id']);
//            $query = WPayAction::updateOrCreate(['transaction_id'=>$query['transaction_id']],$query);
            if ($query['return_code']) === 'SUCCESS') {
                $message = array_merge($query,$message);
            }
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                try {
                    WPayAction::updateOrCreate(['order_id'=>$message['order_id']],$message);
                    // 用户是否支付成功
                    if ($message['return_code'] === 'SUCCESS'&&
                        $message['trade_state'] === 'SUCCESS') {
//                    \Log::notice("订单ID {$order->trade_no} 微信支付成功");
                        $lessonUser = SLessonUser::where('order_id',$order->id)->update(['status'=>2]);
                    }
                    return true;
                }catch (\Exception $exception) {
                    \Log::error('55555微信支付回调处理失败，保存失败');
                    \Log::error($exception);
                    return $fail('保存失败，请稍后再通知我');
                }
            } else {
                \Log::error('微信支付回调处理失败，通信失败');
                return $fail('通信失败，请稍后再通知我');
            }

            \Log::error('55555微信支付回调处理失败，请稍后再通知我');
            return $fail('返回处理失败，请稍后再通知我');
        });

        return $response;
    }

    public function myOrders($type='default')
    {
        $myOrders=Order::where('user_id',auth('api')->user()->uid);
        $pendingOrders = $myOrders->get()->where('trade_state','PENDDING');
        $payment = Factory::payment($this->paymentConfigs[$type]);
        // todo crontab renew order status every night
        foreach ($pendingOrders as $pendingOrder) {
            if (Carbon::now()->diffInDays($pendingOrder->created_at,false)<-1){
                $payment->order->close($pendingOrder->out_trade_no);
            }
            $order = $payment->order->queryByOutTradeNumber($pendingOrder->out_trade_no);
            if ($order['result_code']==='SUCCESS' &&
                $pendingOrder->trade_state<>$order['trade_state']){
                $order['order_id'] = $pendingOrder->id;
                // todo 记录历史订单状态到历史记录表
                WPayAction::updateOrCreate([
                    'out_trade_no' => $pendingOrder->out_trade_no,
                ],$order);
            }
        }
        return \response($myOrders->get(['id','out_trade_no','body','detail','total_fee','created_at','updated_at']));
    }

    public function orderQuery()
    {
//        $dd= WPayAction::with('unifiedorder')->whereHas('unifiedorder',function ($query){
//            $query->where('user_id',auth('api')->user()->uid);
//        })->get(['id','order_id','out_trade_no','trade_state','bank_type','total_fee','created_at','updated_at','unifiedorder']);//
        $dd=Order::where('user_id',auth('api')->user()->uid)->get(['id','out_trade_no','body','detail','total_fee','created_at','updated_at']);
        dd($dd->toArray());
        return \response($dd);
//        $payment = Factory::payment($this->paymentConfigs['default']);
//        $query = $payment->order->queryByTransactionId('4200000334201905295984424976');
//        $dd= WPayAction::updateOrCreate(['out_trade_no'=>$query['out_trade_no']],$query);
//        dd($query,$dd->toArray(),array_intersect_assoc($query,$dd->toArray()));
//        return $query;
    }
}


