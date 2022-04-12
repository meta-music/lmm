<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// oauth和回调
Route::group(['prefix' => 'oauth'], function ($api) {
    // 微信oauth
    $api->group(['prefix' => 'wechat'], function ($api) {
        $api->get('/oalogin', [App\Http\Controllers\Wechat\OfficialController::class,'login']);
        // 微信小程序获取unionId
        $api->post('/mini_login', 'Wechat\ServerController@miniProgramLogin');
        // 微信jssdk
        $api->post('/jssdk', 'Wechat\ServerController@jssdk');
        // 微信网页授权回调
        $api->get('/web', 'Wechat\ServerController@web');
        $api->get('/web-notify', 'Wechat\ServerController@webNotify');

        $api->group([
            'middleware' => 'auth:api',
            'prefix' => 'payment'
        ], function ($router) {
            $router->any('/refund_submit','Wechat\OrderController@payRefundSubmit')->name('payment.refund');
            $router->any('/my_orders','Wechat\OrderController@myOrders');
            $router->any('/user_paying','Wechat\OrderController@userPaying');
            $router->any('/order','Wechat\OrderController@storeOrder')->name('order.create');
        });
        $api->any('/payment/notify', 'Wechat\OrderController@paymentNotify')->name('payment.notify');// 微信支付回调
    });
});
