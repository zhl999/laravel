<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Session;
class PayController extends BaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Topay(Request $request)
    {
        $huoping_id=$request->input('huoping_id');
        $huoping_id_arr=($huoping_id['new_arr']);
        $name=auth()->user();
        $user_id=$name->id;
        $h_arr=[];
        foreach ($huoping_id_arr as $key => $value) {
           $arr=DB::select("select goods.goods_name,huoping.huoping_id,huoping.price,buycar.number,buycar.attr_name from huoping join buycar on huoping.huoping_id=buycar.huoping_id join goods on huoping.goods_id=goods.goods_id where buycar.huoping_id='$value ' and buycar.user_id='$user_id'");
           $h_arr[]=$arr;
        }
        return response()->json($h_arr);    
    }
    public function Toaddress()
    {
        $name=auth()->user();
        $user_id=$name->id;
        $arr=DB::select("select * from address where user_id='$user_id' limit 0,1");
        return response()->json($arr);
    }
    public function Paying (Request $request)
    {
        $z_price=$request->input('z_price');
        $h_arr=$request->input('h_arr');
        $address=$request->input('address');
        $name=auth()->user();
        $user_id=$name->id;
        $time = \Carbon\Carbon::now()->toDateTimeString();
        $tt=date("YmdHis");
        $data=['dingdan_number'=>$tt,'time'=>$time,'user_id'=>$user_id,'z_price'=>$z_price,'status'=>'0'];
        $z_dingdan_id=DB::table("z_dingdan")->insertGetId($data);
        foreach ($h_arr as $key => $value) {
            $id=$value[0]['huoping_id'];
            $price=$value[0]['number']*$value[0]['price'];
            $arr=['z_dingdan_id'=>$z_dingdan_id,'goods_name'=>$value[0]['goods_name'],'huoping_id'=>$value[0]['huoping_id'],'attr_name'=>$value[0]['attr_name'],'price'=>$price,'number'=>$value[0]['number'],'address'=>$address[0]['address_name']];
            $res=DB::table('dingdan')->insert($arr);
            $qs=DB::delete("delete from buycar where user_id='$user_id' and huoping_id='$id'");
        }
        // var_dump($address);
        return response()->json($tt);
    }
}