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
class BuycarController extends BaseController
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
    public function buycar(Request $request)//添加进购物车
    {
        $name=auth()->user();
        $user_id=$name->id;
        $num=$request->input('num');
        $attr_name=$request->input('attr_name');
        $huoping_id=$request->input('huoping_id');
        $harr=Db::select("select * from buycar where user_id='$user_id' and huoping_id='$huoping_id'");
        if ($harr) {
            foreach ($harr as $key => $value) {
                $number=$value->number;
            }
            $n=$num+$number;
            DB::update("update buycar set number = '$n' where user_id = '$user_id' and huoping_id='$huoping_id'");
            return response()->json($num);
        }else{
            $re=DB::table('buycar')->insert(['user_id'=>$user_id,'huoping_id'=>$huoping_id,'number'=>$num,'attr_name'=>$attr_name]);
            return response()->json($re);
        }
        // $res=DB::insert("insert into buycar (user_id, huoping_id, number) values ('$user_id', '$huoping_id','$num')");
    }
    public function gobuy ()
    {
        $name=auth()->user();
        $user_id=$name->id;
        //return response()->json($user_id);
    }
}
