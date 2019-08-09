<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Session;
class IndexController extends BaseController
{
  //   public function list()
  //   {
		// return view("personal/list");
  //   }
  //   public function aa()
  //   {
  //   	$hashed = Hash::make('bb');
        
  //   }
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','goods_attr','showcategory','floor','goodsshow','attrdetails']]);
    }
    public function goods_attr()
    {
    	$results = DB::select("select * from category");
    	//var_dump($results);die;
    	return response()->json($results);
    }
    public function getTree($array, $parent_id , $level)
	{
	    $arr = array();
        foreach ($array as $key => $value){
            if ($value ->parent_id == $parent_id){
            	$value ->src =$level;
            	$value ->sos = $this->getTree($array,$value->cat_id,$level+1);
                $arr[]=$value;
            }
        }
	    return $arr;
	}
	public function showcategory()
	{
		$arr = DB::select("select * from category");
		$ass=$this->getTree($arr,0,0);
		return response()->json($ass);
	}
	public function floor()
	{
		$arr=DB::select("select * from floor join floor_goods on floor.floor_id=floor_goods.floor_id join goods on floor_goods.goods_id=goods.goods_id");
        // var_dump($arr);die;
        $data=[];
        foreach ($arr as $key => $value) {
            $data[$value->floor_name][]=[$value->goods_name,$value->goods_id];
        }
         // var_dump($data);
		return response()->json($data);
	}
  public function goodsshow(Request $request)
  {
    $goods_id=$request->input('goods_id');
    $arr=DB::select("select * from goods join goods_attr on goods.goods_id=goods_attr.goods_id join attr_details on goods_attr.attr_details_id=attr_details.attr_details_id join attr on goods_attr.attr_id=attr.attr_id where goods.goods_id='$goods_id'");
    $data=[];
    foreach ($arr as $key => $value) {
      $data[$value->attr_name][]=[$value->attr_detail_name,$value->attr_details_id];
    }
    $attr['name']=$value->goods_name;
    $attr['data']=$data;
    return response()->json($attr);
  }
  public function attrdetails(Request $request)
  {
    $attr_details_id=$request->input('attr_details_id');
    $attr_details_id=substr($attr_details_id,1);
    $goods_id=$request->input('goods_id');
    $arr=DB::select("select * from huoping where goods_id='$goods_id' and goods_attr_id='$attr_details_id'");
    // $arr=DB::select("select * from huopin")
    return response()->json($arr);
  }
  public function buycar(Request $request)
  {
    $num=$request->input('num');
    $username=$request->input('username');
    $huoping_id=$request->input('huoping_id');
    $user_id=DB::select("select id from users where name='$username'");
      foreach ($user_id as $key => $value) {
        $user_id=$value->id;
      }
    $harr=Db::select("select * from buycar where user_id='$user_id' and huoping_id='$huoping_id'");
    if ($harr) {
      $num=$num+$num;
      DB::update("update buycar set number = '$num' where user_id = '$user_id' and huoping_id='$huoping_id'");
      return response()->json($num);
      // $arr=['number'=>$num];
      // //Db::update("update buycar set `number` ")
      // $re=DB::table('buycar') ->where('huoping_id','=',$huoping_id ) ->update($arr);
    }else{
      $user_id=DB::select("select id from users where name='$username'");
      foreach ($user_id as $key => $value) {
        $user_id=$value->id;
      }
      $re=DB::table('buycar')->insert(['user_id'=>$user_id,'huoping_id'=>$huoping_id,'number'=>$num]);
      return response()->json($re);
    }
    //$res=DB::insert("insert into buycar (user_id, huoping_id, number) values ('$user_id', '$huoping_id','$num')");
    
    
  }
}