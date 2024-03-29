<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/aa', function () {
    echo $hashed = Hash::make('aa');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('login','LoginController@login');
Route::post('loginaction','LoginController@loginaction');

Route::get('index/showcategory','IndexController@showcategory');
	Route::get('index/getTree','IndexController@getTree');
	Route::get('index/floor','IndexController@floor');