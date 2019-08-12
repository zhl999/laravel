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
class AddressController extends BaseController
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
    public function Address(Request $request)
    {
        $p_id=$request->input('p_id');
        $name=auth()->user();
        $user_id=$name->id;
        $arr=DB::select("select * from area where parent_id = '$p_id'");

        return response()->json($arr);
        
        // $res=DB::insert("insert into buycar (user_id, huoping_id, number) values ('$user_id', '$huoping_id','$num')");
    }
    public function tjaddress(Request $request)
    {
        $name=auth()->user();
        $user_id=$name->id;
        $address=$request->input('address');
        $s_h_name=$request->input('s_h_name');
        $s_h_phone=$request->input('s_h_phone');
        $arr=DB::select("select * from address where user_id='$user_id' and address_name='$address' and s_h_name='$s_h_name' and s_h_phone='$s_h_phone'");
        if (empty($arr)) {
            $re=DB::table('address')->insert(['user_id'=>$user_id,'address_name'=>$address,'s_h_name'=>$s_h_name,'s_h_phone'=>$s_h_phone]);
            return response()->json($re);
        }else{
            // $re=DB::update("update address set address_name = '$address', s_h_name='$s_h_name',s_h_phone='$s_h_phone' where user_id = '$user_id'");
            return response()->json("该地址已存在！");
        }
        

    }
}
