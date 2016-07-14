<?php
namespace App\Http\Controllers\home;

use App\WalletLog;
use Request;
use Validator;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\Wallet;
use DB;

class WalletLogController extends CommonController {

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
	public function lists() {
	    $pageRow = Request::input('rows',15);

	    $user_id = Session::get('laravel_user_id');

	    $where = array();

        $where['u_id'] = $user_id;

        $wallet_log_list = WalletLog::where($where)->with('users')->orderBy('id','desc')->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.walletLog.li',array('wallet_log_list' => $wallet_log_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.walletLog.lists',array('wallet_log_list' => $wallet_log_list));
	    }
	}


	public function adminLists($id = 0){
		$pageRow = Request::input('rows',15);

        $where['u_id'] = $id;

        $wallet_log_list = WalletLog::where($where)->with('users')->orderBy('id','desc')->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.walletLog.li',array('wallet_log_list' => $wallet_log_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.walletLog.lists',array('wallet_log_list' => $wallet_log_list));
	    }
	}

}
