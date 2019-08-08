<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class LoginController extends BaseController
{
    public function login()
    {
        $res=DB::select("select * from goods join goods_attr on goods.goods_id=goods_attr.goods_id join attr_details on goods_attr.attr_details_id=attr_details.attr_details_id join attr on goods_attr.attr_id=attr.attr_id where goods.goods_id=4");
        var_dump($res);
    	// return view("login");
    }
    // public function loginAction(Request $request)
    // {
    //     $name=$request->input('name');
    //     $password=$request->input('pwd');
    //     $res=DB::select("select * from test where name='$name' and password='$password'");
    //     // $request ->session() ->put("name",$name);
    //     if (empty($res)) {
    //         $arr=['code'=>'1','status'=>'error','data'=>'用户名密码错误'];
    //         echo json_encode($arr);
    //     }else{
    //         $name=Session::put("name",$name);
    //         $arr=['code'=>'0','status'=>'ok','data'=>'用户名密码正确'];
    //         echo json_encode($arr);
    //     }
    // }
    // public function loginOut(Request $request)
    // {
    //     //$request->session()->flush();
    //     $request->session()->forget('name');
    //     return redirect()->action('LoginController@login');

    // }
}