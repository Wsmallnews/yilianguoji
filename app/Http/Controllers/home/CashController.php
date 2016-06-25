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

class CashController extends CommonController {

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

    public function add() {
		// Session::put('createName',$this->createName());
        return view('home.cash.add');
    }

    public function doAdd() {
		$user_id = Session::get('laravel_user_id');

        $data = Request::input();

		if($data['money'] <= 0){
			return Redirect::back()->withInput(Request::input())->withErrors('提现金额必须大于0');
		}

		DB::beginTransaction();
		try{
			//扣除钱包余额，增加锁定余额
			$wallet = Wallet::findorFail($user_id);

			$result = $wallet->virtualReduceMoney($data['money']);

			if(!$result){
				throw new Exception("钱包余额不足，无法提现");
			}
			$cash = new Cash($data);
			$cash->u_id = $user_id;
			$cash->save();

			DB::commit();
	        return redirect()->intended('home/cashList');

		}catch(Exception $e){
			DB::rollback();
			return Redirect::back()->withInput(Request::input())->withErrors('余额不足，无法提现');
		}
    }
}
