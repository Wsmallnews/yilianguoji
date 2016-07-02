<?php
namespace App\Http\Controllers\home;

use Request;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\Wallet;
use App\User;
use \Exception;
use Log;

class WalletController extends CommonController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('home');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function wallet() {
		$wallet = AuthUser::user()->getWalletOne()->first();

		return view('home.wallet.wallet',array('wallet' => $wallet));
	}

	public function walletUp(){
		$keyword = Request::input('keyword');

		if (!empty($keyword)) {
			$user_list = User::where('name','like','%'.$keyword.'%')->get();
		}else{
			$user_list = User::get();
		}

		if(Request::ajax()){
			$view = view('home.wallet.option',array('user_list' => $user_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));
		}else{
			return view('home.wallet.walletUp',array('user_list' => $user_list));
		}
	}

	public function doWalletUp(){
		$user_id = Request::input('user_id');
		$money = Request::input('money');

		try{
			$wallet = Wallet::findorFail($user_id);

			$result = $wallet->increaseMoney($money,6);
			if(!$result){
				throw new Exception("充值-钱包编辑失败，用户id为：".$user_id."日志结束");
			}
			return redirect('home/index');
		}catch(Exception $e){
			Log::info('catchError',['message',$e->getMessage()]);

			return Redirect::back()->withInput(Request::input())->withErrors('充值失败');
		}
	}
}
