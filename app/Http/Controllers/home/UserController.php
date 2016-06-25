<?php
namespace App\Http\Controllers\home;

use App\User;
use Request;
use Validator;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\Wallet;
use DB;
use Hash;
use App\AutoUp;
use Queue;
use App\Commands\SeePrize;
use \Exception;

class UserController extends CommonController {

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
            $where['parent_id'] = $user_id;
        }

        $user_list = User::where($where)->with('parent')->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.user.li',array('user_list' => $user_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.user.lists',array('user_list' => $user_list));
	    }
	}

    public function add() {
		// Session::put('createName',$this->createName());
        return view('home.user.add');
    }

    public function doAdd() {
		$l_web = app('l_web');

		$user_info = AuthUser::user();

		//每人最多邀请三个直属
		if($user_info->children_num >= 3){
			return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('最多添加三个直属');
		}

		$data = Request::input();
		$data['parent_id'] = Session::get('laravel_user_id');

        $validate = Validator::make($data,User::addFastRole(),User::addFastRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors($validate->errors());
        }

		DB::beginTransaction();
		try {
			//修改用户信息
			$user_info->children_num = $user_info->children_num + 1;
			$user_info->save();

			$data['password'] = bcrypt($data['password']);//设置密码
	        $user = new User($data);
			$result = $user->save();

			$u_id = $user->id;
			$wallet = new Wallet();
			$result = $wallet->find($u_id);
			if(!$result){
				$wallet->doAdd($u_id);
			}

			DB::commit();
			return redirect('home/userList');
		}catch(Exception $e) {
			DB::rollback();
            return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('添加失败');
		}
    }


	public function doUserActive(){
		$id = Request::input('id',0);

		$user = User::find($id);

		if($user->status){
			return Response::json(array('error'=>1,'info' => '该用户已激活，不需要重复激活'));
		}

		if($user->parent_id != Session::get('laravel_user_id')){
			return Response::json(array('error'=>1,'info' => '您不能激活该用户'));
		}

		DB::beginTransaction();

		try{
			$wallet = Wallet::findorFail(Session::get('laravel_user_id'));

			// 扣除登录用户亿联币
			$result = $wallet->reduceMoney(app('l_web')->active_money,-2);	//用户激活
			if(!$result){
				//钱包执行失败
				throw new Exception("钱包余额不足，请进行充值");
			}

			//修改用户为已激活
			$user->status = 1;
			$user->invi_at = date('Y-m-d H:i:s');

			$result = $user->save();

			//添加队列
			Queue::push(new SeePrize($id));

			DB::commit();
			return Response::json(array('error'=>0,'info' => '激活成功'));
		}catch(Exception $e) {
			DB::rollback();
            return Response::json(array('error'=>1,'info' => '激活失败'));
		}
	}


	public function edit(){
		$user = AuthUser::user();

		return view('home.user.edit',array('user' => $user));
	}

	public function doEdit(){
		$data = Request::input();

		$validate = Validator::make($data,User::editRole(Session::get('laravel_user_id')),User::editRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withInput($data)->withErrors($validate->errors());
        }

		//过滤model ，一个一个赋值然后修改，只能修改自己
		$user = AuthUser::user();
		$user->fill($data);

        $user->save();

		return redirect('home/index');
	}

	public function editPass(){
		return view('home.user.editPass');
	}

	public function doEditPass(){
		$data = Request::input();

		if($data['password'] != $data['confirm_password']){
			return Redirect::back()->withInput($data)->withErrors('两次输入密码不一致');
		}

		$user = AuthUser::user();

		if(!Hash::check($data['old_password'],$user['password'])){
			return Redirect::back()->withInput($data)->withErrors('原密码不正确');
		}

		$user->password = bcrypt($data['password']);

		$user->save();

		return redirect('home/index');
	}

	public function selfUp(){
		$user = AuthUser::user();
		$auto_up = AutoUp::get();

		return view('home.user.selfUp',array('user' => $user,'auto_up' => $auto_up));
	}

	public function doSelfUp(){
		$user = AuthUser::user();

		if($user->rank >= 10){
			return Response::json(array('error'=>1,'info' => '您的等级已经达到最高，不能进行升级'));
		}

		DB::beginTransaction();
		try{
			$rank = $user->rank + 1;	//将要升到这个级别
			$auto_up = AutoUp::where('rank' , $rank)->firstOrFail();
			$need_money = $auto_up->need_money;		//升到这个级别需要的亿联币

			$wallet = Wallet::findorFail(Session::get('laravel_user_id'));

			// 自助升级，扣除自己亿联币
			$result = $wallet->reduceMoney($need_money,-3);
			if(!$result){
				//钱包执行失败
				throw new Exception("钱包余额不足，请进行充值");
			}

			// 自助升级，给上级用户 增加亿联币
			$level_parent_id = $user->getParents($rank);
			$walletP = Wallet::findorFail($level_parent_id);

			$end_need_money = app('l_web')->repeat_scale * $need_money;
			$result = $walletP->increaseMoney($end_need_money,4);
			if(!$result){
				//钱包执行失败，给用户互助奖励失败
				throw new Exception("钱包编辑失败");
			}

			//修改用户等级
			$user->rank = $rank;

			$result = $user->save();

			DB::commit();
			return Response::json(array('error'=>0,'info' => '自助升级成功'));
		}catch(Exception $e) {
			//可以捕获 throw 扔出的，也可以捕获 findorFail 扔出的  findorFail 会抛出具体信息 所以不使用$e->getMessage();作为返回结果
			DB::rollback();
            return Response::json(array('error'=>1,'info' => '自助升级失败'));
		}
	}

	public function nameUnique(){
		$name = Request::input('name','');
		$result = User::where('name',$name)->count();

		if($result){
			return Response::json(array('error'=>1,'info' => '用户名已存在'));
		}else{
			return Response::json(array('error'=>0,'info' => '用户名可以使用'));
		}
	}

	// public function createName(){
	//     $success = true;
	//
	//     do{
	//         //生成唯一用户str
    // 	    $str = 'yl';
	//
    // 	    $str .= mt_rand(10000000,99999999);
	//
    // 	    $count = User::where('name' , $str)->count();
	//     }while($count > 0);
	//
	//     return $str;
	// }

	//平分奖励
	public function shareMoney(){
		$where['status'] = 1;	//必须是已经激活的用户
		$user_list = User::where($where)->get();

		//总会员数
		$user_count = count($user_list);

		//获取公司今日新增业绩
		$date = date('Y-m-d');
		$user_today_count = User::where($where)->where('invi_at','like',$date."%")->count();

		$today_money = $user_today_count * app('l_web')->active_money;

		if($today_money < app('l_web')->low_share_money){
			//如果今日公司新增业绩小于low_share_money，就不进行评分操作，直接进行日志记录

		}else{
			$share_money = $today_money * app('l_web')->share_money_scale;

			$wallet = new Wallet();
			$every_money = $share_money / $user_count;	//每人应得金额

			DB::beginTransaction();

			try{
				foreach($userList as $key => $value){
					$u_wallet = $wallet->find($value->id);
					if($u_wallet){
						$result = $u_wallet->increaseMoney($every_money,3);
						if(!$result){
							throw new Exception("钱包编辑失败---用户id=".$value->id);
						}
					}
				}
				DB::commit();
				return true;
			}catch(Exception $e){
				DB::rollback();
				return false;
			}
		}
	}

}
