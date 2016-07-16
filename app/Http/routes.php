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
Route::group(['prefix' => 'home', 'namespace' => 'home','middleware' => 'home'], function()
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

    Route::get('userEdit/{id?}', 'UserController@edit');              //修改用户信息
    Route::post('userDoEdit', 'UserController@doEdit');
    Route::get('userEditBank', 'UserController@editBank');      //修改密码
    Route::post('userDoEditBank', 'UserController@doEditBank');
    Route::get('userEditPass', 'UserController@editPass');      //修改密码
    Route::post('userDoEditPass', 'UserController@doEditPass');
    Route::get('userSelfUp', 'UserController@selfUp');          //会员自助升级
    Route::get('userDoSelfUp', 'UserController@doSelfUp');
    Route::get('userNetwork', 'UserController@userNetwork');

    //提现
    Route::get('cashList', 'CashController@lists');
    Route::get('cashAdd', 'CashController@add');
    Route::post('cashDoAdd', 'CashController@doAdd');

    //我的钱包
    Route::get('myWallet', 'WalletController@wallet');
    Route::get('walletLog', 'WalletLogController@lists');

    //系统公告
    Route::get('articleView/{id?}', 'ArticleController@view');
    Route::get('articleList', 'ArticleController@lists');

    //公司分红
    Route::get('shareMoney', 'UserController@shareMoney');
    Route::get('rankShareMoney', 'UserController@rankShareMoney');

    //超级管理员分组
    Route::group(['middleware' => ['admin', 'after']],function(){
        //系统设置
        Route::get('setting', 'SettingController@setting');         //设置
        Route::post('settingDoEdit', 'SettingController@doEdit');       //进行设置
        Route::get('walletUp', 'WalletController@walletUp');        //用户提现列表
        Route::post('doWalletUp', 'WalletController@doWalletUp');           //处理钱包提现
        Route::get('adminCashList', array('as' => 'cashAdmin','uses' => 'CashController@adminLists'));      //管理员提现列表
        Route::get('doApply', 'CashController@doApply');        //处理提现
        Route::get('adminUserList', array('as' => 'userListAdmin','uses' => 'UserController@lists'));  //管理员用户列表
        Route::get('adminUserNetwork/{id?}/{keyword?}', 'UserController@adminUserNetwork');           //管理员网络图
        Route::get('adminUserAdd', array('as' => 'userAddAdmin','uses' => 'UserController@add'));       //管理员添加用户
        Route::get('resetPass', 'UserController@resetPass');       //管理员重置密码
        Route::get('userFreeze', array('as' => 'userListAdmin','uses' => 'UserController@freeze'));  //用户冻结，解冻

        Route::get('articleAdd', 'ArticleController@add');
        Route::get('articleEdit/{id?}', 'ArticleController@Edit');
        Route::post('articleDoAddEdit', 'ArticleController@doAddEdit');
        Route::get('adminArticleList', array('as' => 'articleListAdmin','uses' => 'ArticleController@adminLists'));       //管理员添加文章


        Route::get('adminWalletList', 'WalletController@adminLists');   //钱包列表
        Route::get('adminWalletLogList/{id?}', 'WalletLogController@adminLists');   //钱包记录列表

        Route::get('adminRechargeLogList/{id?}', 'RechargeLogController@adminLists');   //充值记录

    });
});


Route::group(['middleware' => 'home'],function(){
    Route::get('/', 'home\IndexController@login');
    Route::get('home', 'home\IndexController@login');
});
// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);


// Event::listen('illuminate.query', function($sql, $param)
//
// {
//Log::info($sql . ", with[" . join(',', $param) ."]");
//var_dump($sql);//sql 预处理 语句
//var_dump($param);

// });
