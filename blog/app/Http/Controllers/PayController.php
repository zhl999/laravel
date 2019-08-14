<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;

class PayController extends Controller
{
    protected $config = [
        'alipay' => [
            'app_id' => '2016101000654812',
            'notify_url' => 'http://localhost/laravel/laravel/blog/public/api/paya/notify',
            'return_url' => 'http://localhost/laravel/laravel/blog/public/api/paya/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnT55HgS7DiuMU8ybuPNhDCCTp5/TKn7mTj+qFUFb5XRMJ97Mb8K6UaRxoW5Iq3dFktACjeSXrQEL6njkirZpx97LJ28Bz8vzJc251WqArbzwDMtV+8dtgjS1R28qg0Zt1yzzaSrHK63FPjRSwkjico+xTp49YVMWeV9hFVAhmAP8F2KYZNpqs+0QlNTWzqLFpPSMocDgUd1spI8YyiSNdalV0bye6xboFxvc6ib2aSo/4oMtwDdsw7bgwQRzV+3FuBz5Yh76aPzmRjZtsfzSB5l8KDi2wq77Q/cUMsLCNZvOfKFAbXXpzgkyvLrYs2r7ps/0Jizi6O1xtyspPU8eVwIDAQAB',
            'private_key' => 'MIIEpQIBAAKCAQEA1MI0UzKxgXXHS6yZUs2XxM515xQcRCS7oR1gHZSoh9CqD6+8OXn86EabmqJG+YRcYXxa3YzZwhJWt+9jM0UaiRnwS3NVHLqM9fp+2XXAkqaw6j3MUXb1apiVGQuRJT9sYQiQ6fl4t3Yg2clEJDS8m+VluzDH2PIuDa+bRayXEA3hQSqVxLx/3plQ2H9QfYwpfDt3vkegNsoZBv8GutfWwnmwegT9IIq22u7JCxulAJSlkbRIhB04xlOggU4Oag9m7VVxZonUQLK7CmGWrA55egYUBYVxqDDyrg070UKgF+EyM8/rRBVhZTK7w5XM2UKOwRxI2jQeIp/e7SVh2yHLiwIDAQABAoIBAQCdOqfQlDX5pkCR/AuS1bzDBJC9JG9/LGY8uqi9M48YT2xeC1DeaPgt74Au1p3854QdxvifoeeLNGJBq/dzfC4QA8tA9wp/IJ3raiM0MYEO34D+mozT50WWcQw+Zf3tuOEvFFWDk4lSi0nbqJFi8FYyH2T+4R3PhanjE1N8Of+pLD/DlADByPUwnOG9YY7+GlwFPOXfq4fDsElz63FhOhMTkVmwC90t+ITrB0muvNwWl5muelfCK2OsODLE5TL3wYPhsXa1FIBeJ91FIUq8AvcoBU9//LtHyhkOeQMcqAVSrY/pgC/C0O44zJxQqnsD/a/YW59QIZEDTBY5fIHibDqBAoGBAOwzqKt3d2EVfLokA0mAVtSviGO90Z6hgb9rspdhzMxrYdvOS1pNurynIQ2StTIL6SHbtlJsJfeGUw0NwNt57hfalunXLSIvoaXdGAsb3LNjVc3J7Wm+AcsBZzto+Hip8FOtoSyYej0r9Ws/aJSIgq09QNJAMvDM3lkduZ77gGUPAoGBAOaXgmZWsNQOycez4ALDJHKn3Q1BERKAb2/++7meq4kgWfsPJxZMDw2M9nigXkXcSy9x4+FOqtr2RvIEuEoK1MtK9N1zZN7KkxgnHwGOQuzZZHU6F2vwlVBO7ni5QD+lJrpf3vG8bqaqwz/0XjXJTbAtcs6UP8EkNkQ8wiJG0YnFAoGBANPLeonNxMjT6JRMKHpmzvVFNGojUewI6/vFyUz+kBIYk5XyBBVEL5Zr0jKGg10N2wzWI0UC3oR1+NByraTfT0QqaDnkDP9jcHH2r1F+uUZNYyn0z6KKkrcCWhumg25HC00tGqGPU8S4Pwbcw5y0T2Ch1RbyI/tR6GpGQiQxZi63AoGAXq+yJRHN9JXJ943+G0REUCxr0ch5GS7SE5wRg4wLBfjZ2gTD2R0MRVUv1CKN84Pc/7N1jov+DoF4amLTxduiu4Og/tomfnGSayWNTtc61gUCgjyDZ5hXx61RsRLotfm76GX7pynoCdou6LEQimeJ1iEjdn5bm5SiD+0fDnIkEr0CgYEA6bOS5+NEubR4W/qT1pOb7kDSUNdmM18N90Cl+2AXn9nmJ+evze/S5a51vNNaiVQ5JAKKje8BzlJYq7aPbXvcHcvIWkaaqra4ACmd+rotL6aVGe7QnJdMHsdAiTSoAJYnyXoJcP7PJWVYy4/x8ZiSvI3yViuIPD/84GNcYgyWY4M=',
        ],
    ];
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['return','notify']]);
    }
    public function index(Request $request)
    {

        $config_biz = [
            'out_trade_no' => $request->input('order'),//订单号
            'total_amount' => $request->input('oid'), //价格
            'subject'      => 'test subject',//名字随便取
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);
        header("location:http://localhost:8080/?#/index");
        // return $pay->driver('alipay')->gateway()->verify($request->all());
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。 
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号； 
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）； 
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）； 
            // 4、验证app_id是否为该商户本身。 
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}