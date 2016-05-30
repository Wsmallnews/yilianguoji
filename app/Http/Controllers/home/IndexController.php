<?php
namespace App\Http\Controllers\home;

use App\User;
use Request;
use Validator;
use Redirect;
use AuthUser;
use App\Wallet;
use Session;

class IndexController extends CommonController {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('home');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
	    return view('home.index.index');
	}


	public function login()
	{
	    return view('home.login');
	}


	public function doLogin(){

        $data = Request::all();

        $validate = Validator::make($data,User::loginRole(),User::loginRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withErrors($validate);
        }

        if (AuthUser::attempt($data)){
            return redirect()->intended('home/index');
        }else{
            return Redirect::back()->withInput(Request::except('password'))->withErrors('密码错误');
        }
	}

    //登出
	public function getLogout()
	{
	    AuthUser::logout();
	    return redirect('home/login');
	}


}
