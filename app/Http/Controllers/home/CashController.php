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
		// $l_web = app('l_web');

		// $inviteCode = new InviteCode();
		DB::beginTransaction();

        $data = Request::input();

        // $validate = Validator::make($data,Cash::addRole(),Cash::addRoleMsg());
		//
        // if($validate->fails()){
        //     return Redirect::back()->withInput(Request::input())->withErrors($validate->errors());
        // }

		if($data['money'] <= 0){
			return Redirect::back()->withInput(Request::input())->withErrors('提现金额必须大于0');
		}

		//扣除钱包余额，增加锁定余额
		$result = AuthUser::user()->getWalletOne()->first();

		if($result){
			$result = $result->virtualReduceMoney($data['money']);
		}

		if($result){
			$cash = new Cash($data);

	        $cash->u_id = Session::get('laravel_user_id');

	        $result = $cash->save();
		}

        if ($result){
			DB::commit();
            return redirect()->intended('home/cashList');
        }else{
			DB::rollback();
            return Redirect::back()->withInput(Request::input())->withErrors('提现申请失败');
        }
    }
}
