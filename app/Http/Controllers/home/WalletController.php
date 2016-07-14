<?php
namespace App\Http\Controllers\home;

use Request;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\Wallet;
use App\User;
use App\RechargeLog;
use \Exception;
use Log;
use DB;

class WalletController extends CommonController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function _initialize()
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

		DB::beginTransaction();
		try{
			if($money == 0){
				throw new Exception("充值-金额不能等于0，用户id为：".$user_id."日志结束");
			}

			$wallet = Wallet::findorFail($user_id);

			$result = $wallet->increaseMoney($money,6);
			if(!$result){
				throw new Exception("充值-钱包编辑失败，用户id为：".$user_id."日志结束");
			}

			$rechargeLog = new RechargeLog();
			$rechargeLog->u_id = $user_id;
			$rechargeLog->money = $money;

			$rechargeLog->save();

			DB::commit();
			if(Request::ajax()){
				return Response::json(array('error'=>0,'info'=>'充值成功'));
			}else{
				return redirect('home/index')->withSuccess('充值成功');
			}

		}catch(Exception $e){
			Log::info('catchError',['message',$e->getMessage()]);

			DB::rollback();
			if(Request::ajax()){
				return Response::json(array('error'=>1,'info'=>'充值失败'));
			}else{
				return Redirect::back()->withInput(Request::input())->withErrors('充值失败');
			}
		}
	}

	public function adminLists() {
		$data = Request::all();

	    $pageRow = isset($data['rows']) ? $data['rows'] : 15;
		$order = isset($data['order']) ? $data['order'] : 'id';
		$sort = isset($data['sort']) ? $data['sort'] : 'desc';

		$where = array();

		$wallet = new Wallet();

		$wallet_list = $wallet->with('users')->orderBy($order,$sort)->paginate($pageRow);


		// $wallet_list = $wallet->with(['user' => function($query){
		// 	if(!empty($data['keyword'])){
		// 		$query->where('name','like','%'.$data['keyword'].'%');
		// 	}
		// }])->orderBy('id','desc')->paginate($pageRow);
		//
		// print_r($wallet_list);exit;



	    if(Request::ajax()){
	        $view = view('home.wallet.li',array('wallet_list' => $wallet_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));
	    }else{
	        return view('home.wallet.adminLists',array('wallet_list' => $wallet_list));
	    }
	}
}
