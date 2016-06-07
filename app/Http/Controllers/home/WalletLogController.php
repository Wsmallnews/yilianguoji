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
	public function __construct()
	{
		$this->middleware('home');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function lists() {
	    $pageRow = Request::input('rows',15);

	    // $user_id = Session::get('laravel_user_id');

	    $where = array();

        if(!empty($user_id)){
            $where['u_id'] = $user_id;
        }

        $wallet_list = WalletLog::where($where)->with('user')->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.walletLog.li',array('wallet_list' => $wallet_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.walletLog.lists',array('wallet_list' => $wallet_list));
	    }
	}

}
