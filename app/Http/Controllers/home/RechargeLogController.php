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
use App\RechargeLog;
use DB;

class RechargeLogController extends CommonController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function _initialize()
	{
		//$this->middleware('home');
	}

	public function adminLists($id = 0){
		$pageRow = Request::input('rows',15);

		$where = array();
		if($id){
			$where['u_id'] = $id;
		}

        $recharge_list = RechargeLog::where($where)->with('users')->orderBy('id','desc')->paginate($pageRow);
	    if(Request::ajax()){

	        $view = view('home.rechargeLog.li',array('recharge_list' => $recharge_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.rechargeLog.lists',array('recharge_list' => $recharge_list));
	    }
	}

}
