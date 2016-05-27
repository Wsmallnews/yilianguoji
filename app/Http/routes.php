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

//Route::get('/', 'WelcomeController@index');


//前台路由组
Route::group(['prefix' => 'home', 'namespace' => 'home'], function()
{

    Route::match(['get','post'],'login', array('as' => 'login','uses' => 'IndexController@login'));
    Route::post('doLogin', array('as' => 'doLogin','uses' => 'IndexController@doLogin'));
    Route::get('logout', 'IndexController@getLogout');
    Route::get('/', 'IndexController@index');
    Route::get('index', 'IndexController@index');


    Route::get('userList', 'UserController@lists');
    Route::get('userAdd', 'UserController@add');
    Route::post('userDoAdd', 'UserController@doAdd');
    Route::get('userActive', 'UserController@doUserActive');





















    Route::get('createGive', 'InviteCodeController@createGive');
    Route::get('inviLists', 'InviteCodeController@lists');

    Route::get('inList', 'InQueueController@lists');
    Route::get('inAdd', 'InQueueController@add');
    Route::post('inDoAdd', 'InQueueController@doAdd');

    Route::get('outList', 'OutQueueController@lists');
    Route::get('outAdd', 'OutQueueController@add');
    Route::post('outDoAdd', 'OutQueueController@doAdd');

});



Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Event::listen('illuminate.query', function($sql, $param)

{
//Log::info($sql . ", with[" . join(',', $param) ."]");
//var_dump($sql);//sql 预处理 语句
//var_dump($param);

});
