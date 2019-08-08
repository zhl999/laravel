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
    return response()->json($goods_id);
  }
}