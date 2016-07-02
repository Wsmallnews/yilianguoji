<?php
namespace App\Http\Controllers\home;

use App\Cash;
use Request;
use Validator;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\Wallet;
use DB;

class CronLogController extends CommonController {

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
	public function lists() {
	    $pageRow = Request::input('rows',15);

	    $user_id = Session::get('laravel_user_id');

	    $where = array();

        if(!empty($user_id)){
            $where['u_id'] = $user_id;
        }

        $cash_list = Cash::where($where)->with('user')->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.cash.li',array('cash_list' => $cash_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.cash.lists',array('cash_list' => $cash_list));
	    }
	}

}
