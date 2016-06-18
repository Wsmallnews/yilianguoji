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

    //用户
    Route::get('userList', 'UserController@lists');
    Route::get('userAdd', 'UserController@add');
    Route::post('userDoAdd', 'UserController@doAdd');
    Route::get('userActive', 'UserController@doUserActive');    //激活
    Route::get('userNameUnique', 'UserController@nameUnique');  //检测用户名是否重复

    Route::get('userEdit', 'UserController@edit');              //修改用户信息
    Route::post('userDoEdit', 'UserController@doEdit');
    Route::get('userEditPass', 'UserController@editPass');      //修改密码
    Route::post('userDoEditPass', 'UserController@doEditPass');
    Route::get('userSelfUp', 'UserController@selfUp');          //会员自助升级
    Route::post('userDoSelfUp', 'UserController@doSelfUp');



    //提现
    Route::get('cashList', 'CashController@lists');
    Route::get('cashAdd', 'CashController@add');
    Route::post('cashDoAdd', 'CashController@doAdd');

    //我的钱包
    Route::get('myWallet', 'WalletController@wallet');
    Route::get('walletLog', 'WalletLogController@lists');

    //系统设置
    Route::get('setting', 'SettingController@setting');
    Route::post('settingDoEdit', 'SettingController@doEdit');




















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


// Event::listen('illuminate.query', function($sql, $param)
//
// {
//Log::info($sql . ", with[" . join(',', $param) ."]");
//var_dump($sql);//sql 预处理 语句
//var_dump($param);

// });
