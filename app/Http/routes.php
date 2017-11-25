<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * 登录认证路由
 */
Route::any('Login', 'LoginController@login');
Route::any('loginverify', 'LoginController@loginverify');

/**
 * 请求URL & 回传UR
 */
Route::any('Init', 'InitController@index');
Route::any('CallBack', 'CallBackController@index');
Route::any('Resend', 'ResendController@index');

/**
 * 登录中间件设置
 */
Route::group(['middleware' => ['admin']], function (){
    Route::any('/','IndexController@index');
    Route::any('gettree','IndexController@gettree');
    Route::any('getcode','IndexController@getcode');
    Route::any('getcodetype','IndexController@getcodetype');
    Route::resource('getparam','IndexController@getparam');
    Route::resource('getgameinfo','IndexController@getgameinfo');
    Route::resource('getiteminfo','IndexController@getiteminfo');
    Route::resource('getcodelimit','IndexController@getcodelimit');
    Route::any('getparamtype','IndexController@getparamtype');
    Route::any('getchannel','IndexController@getchannel');
    Route::any('getsp','IndexController@getsp');
    Route::resource('getgame','IndexController@getgame');
    Route::any('getcp','IndexController@getcp');
    Route::resource('setdeduct','IndexController@setdeduct');
    Route::resource('deduct','IndexController@deduct');
    Route::any('test','IndexController@test');

    Route::resource('CodeSort','CodeSortController');
    Route::resource('CodeType','CodeTypeController');
    Route::resource('GameItem','GameItemController');
    Route::resource('CodeInfo','CodeInfoController');
    Route::resource('ItemInfo','ItemInfoController');
    Route::resource('CodeLimit','CodeLimitController');
    Route::resource('Channel','ChannelController');
    Route::resource('Stat','StatController');


    Route::any('Logout', 'LoginController@logout');
});
/*
Route::get('/', function () {
    return view('welcome');
});
*/

