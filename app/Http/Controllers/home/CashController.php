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
use App\User;
use DB;
use \Exception;

class CashController extends CommonController {

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
		$data = Request::all();

	    $pageRow = isset($data['rows']) ? $data['rows'] : 15;

	    $user_id = Session::get('laravel_user_id');

	    $where = array();

        if(!empty($user_id)){
            $where['u_id'] = $user_id;
        }

		if(isset($data['status']) && $data['status'] != 'all'){
            $where['status'] = $data['status'];
        }

        $cash_list = Cash::where($where)->with('user','bank')->orderBy('id','desc')->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.cash.li',array('cash_list' => $cash_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.cash.lists',array('cash_list' => $cash_list));
	    }
	}

    public function add() {
		$user = new User();
		$user = $user->with('bank')->find(Session::get('laravel_user_id'));

		$wallet = Wallet::find(Session::get('laravel_user_id'));

        return view('home.cash.add',array('user' => $user,'wallet' => $wallet));
    }

    public function doAdd() {
		$l_web = app('l_web');

		$user = AuthUser::user();
		$user_id = $user->id;

        $cash_money = Request::input('money');

		if($cash_money <= 0){
			return Redirect::back()->withInput(Request::input())->withErrors('提现金额必须大于0');
		}

		DB::beginTransaction();
		try{
			//扣除钱包余额，增加锁定余额
			$wallet = Wallet::findorFail($user_id);

			//提现手续费
			$charge_money = 0;

			if($l_web->is_charge){	//如果开启提现手续费开关，计算手续费
				$charge_money = sprintf("%.2f",($cash_money * $l_web->charge_scale));
				if($charge_money < $l_web->low_charge_money){
					$charge_money = $l_web->low_charge_money;
				}
			}

			$total_money = $charge_money + $cash_money;

			//虚拟减少提现金额
			$result = $wallet->virtualReduceMoney($total_money);

			if(!$result){
				throw new Exception("钱包余额不足，无法提现");
			}

			$cash = new Cash();
			$cash->u_id = $user_id;
			$cash->money = $cash_money;
			$cash->charge_money = $charge_money;
			$cash->card_type = $user->card_type;
			$cash->card_bank = $user->card_bank;
			$cash->card_name = $user->card_name;
			$cash->card_no = $user->card_no;
			$cash->save();

			DB::commit();
	        return redirect()->intended('home/cashList')->withSuccess('提现申请成功');

		}catch(Exception $e){
			print_r($e->getMessage());exit;
			DB::rollback();
			return Redirect::back()->withInput(Request::input())->withErrors('余额不足，无法提现');
		}
    }


	public function adminLists() {
		$data = Request::all();

	    $pageRow = isset($data['rows']) ? $data['rows'] : 15;

		$where = array();

		$cash = new Cash();
		if(!empty($data['keyword'])){
			$cash->where('name','like','%'.$data['keyword'].'%');
		}

		if(isset($data['status']) && $data['status'] != 'all'){
			$cash->where('status',$data['status']);
		}

        $cash_list = $cash->with('user','bank')->orderBy('id','desc')->paginate($pageRow);

	    if(Request::ajax()){
	        $view = view('home.cash.li',array('cash_list' => $cash_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));
	    }else{
	        return view('home.cash.lists',array('cash_list' => $cash_list));
	    }
	}

	public function doApply(){
		$id = Request::input('id',0);
		$status = Request::input('status',0);
		$fail_msg = Request::input('fail_msg','');

		DB::beginTransaction();

		try {
			$cash = Cash::findOrFail($id);

			if($cash->status != 0){
				throw new Exception('该申请已处理，不需再次处理');
			}

			//本次提现扣除的总金额
			$total_money = $cash->money + $cash->charge_money;	//提现金额，加手续费

			if($status == 1){
				//扣除钱包锁定余额
				$wallet = Wallet::findOrFail($cash->u_id);

				$result = $wallet->realReduceMoney($cash->money,-1);

				if(!$result){
					throw new Exception("该用户锁定余额不足");
				}

				$result = $wallet->realReduceMoney($cash->charge_money,-4);

				if(!$result){
					throw new Exception("该用户锁定余额不足");
				}
			}else if($status == -1){
				//资金回滚，扣除锁定余额，增加余额
				$wallet = Wallet::findOrFail($cash->u_id);

				$result = $wallet->rollBackMoney($total_money);

				if(!$result){
					throw new Exception("该用户锁定余额不足");
				}
			}

			//修改提现状态
			$cash->fail_msg = $fail_msg;
			$cash->status = $status;
			$cash->save();

			DB::commit();
	        return Response::json(array('error'=>0,'info' => '处理成功'));

		}catch(Exception $e){
			DB::rollback();
			return Response::json(array('error'=>1,'info' => $e->getMessage()));
		}
	}
}
