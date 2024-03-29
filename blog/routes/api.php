<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    // Route::post('buycar', 'IndexController@buycar');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'car'

], function ($router) {

    Route::post('buycar', 'BuycarController@buycar');
    Route::post('gobuy', 'BuycarController@gobuy');
    Route::post('carshow', 'BuycarController@carshow');
    Route::post('greed', 'BuycarController@greed');

});
Route::group([

    'middleware' => 'api',
    'prefix' => 'pay'

], function ($router) {

    Route::post('topay', 'PayedController@topay');
    Route::post('toaddress', 'PayedController@toaddress');
    Route::post('paying', 'PayedController@paying');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'address'

], function ($router) {

    Route::post('address', 'AddressController@address');
    Route::post('tjaddress', 'AddressController@tjaddress');
    Route::post('alladd', 'AddressController@alladd');

});
	// Route::get('index/showcategory','IndexController@showcategory');
	// Route::get('index/getTree','IndexController@getTree');
	// Route::get('index/floor','IndexController@floor');
	Route::post('index/goodsshow','IndexController@goodsshow');
	Route::post('index/attrdetails','IndexController@attrdetails');

Route::group([

    'middleware' => 'api',
    'prefix' => 'paya'

], function ($router) {

    Route::get('index', 'PayController@index');
    Route::get('return', 'PayController@return');
    Route::get('notify', 'PayController@notify');

});

	