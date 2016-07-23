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
use App\CronLog;
use Hp;
use Log;
use Route;
use App\Bank;
use Event;
use App\Events\LogEvent as AdminLog;

class UserController extends CommonController {

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
		$user = AuthUser::user();

		if($user->super_man && Route::currentRouteName() == 'userListAdmin'){
			$userModel = User::withTrashed();
		}else{
			$userModel = User::where('parent_id',$user_id)->orwhere('direct_id',$user_id);
		}

        $user_list = $userModel->with('parent')->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.user.li',array('user_list' => $user_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.user.lists',array('user_list' => $user_list));
	    }
	}

    public function add() {
		$user = AuthUser::user();
		$keyword = Request::input('keyword','');
		if($user->super_man){

			if (!empty($keyword)) {
				$user_list = User::where('name','like','%'.$keyword.'%')->get();
			}else{
				$user_list = User::get();
			}
		}else{
			$start_list = array();
			if(!empty($keyword)){
				if(strpos($user->name,$keyword) !== false){
					$start_list = array($user);
				}
			}else{
				$start_list = array($user);
			}

			$user_list = $this->getUserChildren(Session::get('laravel_user_id'),$start_list,$keyword);
		}

		if(Request::ajax()){
			$view = view('home.wallet.option',array('user_list' => $user_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));
		}else{
			return view('home.user.add',array('user_list' => $user_list));
		}
    }

    public function doAdd() {
		$l_web = app('l_web');
		$data = Request::all();

		$user = AuthUser::user();

		if(isset($data['direct_id']) && $user->super_man){
			$direct_info = User::find($data['direct_id']);
			if(!$direct_info){
				return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('没有找到该推荐人');
			}
		}else{
			//普通用户推荐人只能是自己
			$direct_info = $user;
			$data['direct_id'] = $direct_info->id;
		}

		if(isset($data['parent_id'])){
			$parent_info = User::find($data['parent_id']);

			if(!$parent_info){
				return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('没有找到该接点人');
			}

			if(!$user->super_man){
				$start_list = array($user->id);
				$user_ids = $this->getUserChildren($user->id,$start_list,'',true);

				if(!in_array($data['parent_id'],$user_ids)){
					return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('不能设置改接点人');
				}
			}
		}else{
			//不填写接点人，接点人就是自己
			$parent_info = $user;
			$data['parent_id'] = $parent_info->id;
		}

		//每人最多邀请三个直属
		if($parent_info->children_num >= 3){
			return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('接点人最多添加三个直属');
		}

        $validate = Validator::make($data,User::addFastRole(),User::addFastRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors($validate->errors());
        }

		DB::beginTransaction();
		try {
			//修改用户信息
			$parent_info->children_num = $parent_info->children_num + 1;
			$parent_info->save();

			$data['password'] = bcrypt($data['password']);//设置密码
	        $user = new User($data);
			$result = $user->save();

			$u_id = $user->id;
			$wallet = new Wallet();
			$result = $wallet->find($u_id);
			if(!$result){
				$wallet->doAdd($u_id);
			}

			$log_data = array(
				'log_info' => '用户添加：成功【id：'.$user->id."】",
			);
			Event::fire(new AdminLog($log_data));

			DB::commit();
			return redirect('home/userList')->withSuccess('用户添加成功');
		}catch(Exception $e) {
			DB::rollback();
            return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('添加失败');
		}
    }


	public function doUserActive(){
		$id = Request::input('id',0);

		$user = User::find($id);

		DB::beginTransaction();

		try{
			if($user->status){
				throw new Exception("该用户已激活，不需要重复激活");
			}

			if($user->direct_id != Session::get('laravel_user_id')){
				throw new Exception("对不起，您不能激活该用户！");
			}

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

			$log_data = array(
				'log_info' => '用户激活：成功【id：'.$user->id."】",
			);
			Event::fire(new AdminLog($log_data));

			//添加队列
			Queue::push(new SeePrize($id));

			DB::commit();
			return Response::json(array('error'=>0,'info' => '激活成功'));
		}catch(Exception $e) {
			DB::rollback();
            return Response::json(array('error'=>1,'info' => $e->getMessage()));
		}
	}


	public function edit($id = 0){
		$user = AuthUser::user();

		if($id && $user->super_man){
			$user = User::find($id);
		}

		return view('home.user.edit',array('user' => $user));
	}

	public function doEdit(){
		$data = Request::input();

		$validate = Validator::make($data,User::editRole($data['id']),User::editRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withInput($data)->withErrors($validate->errors());
        }

		//过滤model
		$user = AuthUser::user();

		if($data['id'] != $user->id && $user->super_man){
			$user = User::find($data['id']);
		}

		$user->fill($data);

        $user->save();

		return redirect('home/index')->withSuccess('资料修改成功');
	}

	public function editBank(){
		$user = AuthUser::user();

		$bank = Bank::del()->get();
		return view('home.user.editBank',array('user' => $user,'bank' => $bank));
	}

	public function doEditBank(){
		$data = Request::input();
		//只能修改自己
		$user = AuthUser::user();
		$user->fill($data);

        $user->save();

		$log_data = array(
			'log_info' => '用户银行卡：编辑成功【id：'.$user->id."】",
		);
		Event::fire(new AdminLog($log_data));

		return redirect('home/index')->withSuccess('银行卡设置成功');
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

		$log_data = array(
			'log_info' => '用户修改密码：成功【id：'.$user->id."】",
		);
		Event::fire(new AdminLog($log_data));

		return redirect('home/index')->withSuccess('密码修改成功');
	}

	public function resetPass(){
		$data = Request::input();

		try{
			if($data['password'] != $data['conf_password']){
				throw new Exception("两次输入密码不一致");
			}

			$user = User::findOrFail($data['id']);

			$user->password = bcrypt($data['password']);
			$user->save();

			$log_data = array(
				'log_info' => '管理员重置密码：成功【id：'.$user->id."】",
			);
			Event::fire(new AdminLog($log_data));

			return Response::json(array('error'=>0,'info' => '重置成功'));
		}catch(Exception $e){
			return Response::json(array('error'=>1,'info' => '重置失败'));
		}
		// return redirect()-back()->with('message',"重置成功");
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
			$level_parent = $user->getParents($rank);
			if($level_parent){
				if($level_parent->rank >= $rank){

					$parents_id = $level_parent->id;
				}else{
					$parents_id = 0;
				}
			}else{
				//没有找到上级，就把钱返给系统钱包
				$parents_id = 0;
			}

			$walletP = Wallet::findorFail($parents_id);

			if(app('l_web')->is_repeat){	//重消开关
				$end_need_money = app('l_web')->repeat_scale * $need_money;
			}else{
				$end_need_money = $need_money;
			}
			$result = $walletP->increaseMoney($end_need_money,4);
			if(!$result){
				//钱包执行失败，给用户互助奖励失败
				throw new Exception("钱包编辑失败");
			}

			//修改用户等级
			$user->rank = $rank;

			$result = $user->save();

			$log_data = array(
				'log_info' => '用户自助升级：成功【id：'.$user->id."】",
			);
			Event::fire(new AdminLog($log_data));

			DB::commit();
			return Response::json(array('error'=>0,'info' => '自助升级成功'));
		}catch(Exception $e) {
			//可以捕获 throw 扔出的，也可以捕获 findorFail 扔出的  findorFail 会抛出具体信息 所以不使用$e->getMessage();作为返回结果
			DB::rollback();
            return Response::json(array('error'=>1,'info' => '自助升级失败'));
		}
	}

	//用户冻结，解冻
	public function freeze(){
		$data = Request::all();

		$user = User::withTrashed()->find($data['id']);

		DB::beginTransaction();
		try {
			if($user->super_man || $user->id == Session::get('laravel_user_id')){
				throw new Exception("对不起，您不能操作该用户！");
			}

			if($data['type'] == 'open'){
				//解封
				if($user->trashed()){
					$user->restore();

					$log_data = array(
						'log_info' => '用户解冻：成功【id：'.$user->id."】",
					);
					Event::fire(new AdminLog($log_data));
				}
			}else if($data['type'] == 'close'){
				if(!$user->trashed()){
					$user->delete();

					$log_data = array(
						'log_info' => '用户冻结：成功【id：'.$user->id."】",
					);
					Event::fire(new AdminLog($log_data));
				}
			}else if($data['type'] == 'del'){
				if($user->trashed()){

					//删除用户
					$parent_id = $user->parent_id;
					$user->forceDelete();

					//删除用户钱包
					$wallet = Wallet::find($user->id);
					if($wallet){
						$blance = $wallet->money;
						$blance_lock = $wallet->money_lock;
						$wallet->delete();
					}

					//上级用户的children_num - 1
					if($parent_id){
						$parent_info = $user->find($parent_id);
						if($parent_info){
							$parent_info->children_num = $parent_info->children_num - 1;
							$parent_info->save();
						}
					}

					$log_data = array(
						'log_info' => '用户删除：成功【id：'.$user->id."】，删除钱包余额：".(isset($blance) ? $blance : 0)."，锁定余额：".(isset($blance_lock) ? $blance_lock : 0)."，上级用户id：".$parent_id,
					);
					Event::fire(new AdminLog($log_data));
				}
			}

			DB::commit();
			return Response::json(array('error'=>0,'info' => '操作成功'));
		}catch(Exception $e){
			DB::rollback();
			return Response::json(array('error'=>1,'info' => $e->getMessage()));
		}
	}


	public function userNetwork(){

		$user = AuthUser::user();

		$user_id = $user['id'];

		$son_list = User::where('parent_id',$user_id)->orderBy('id', 'asc')->get()->toArray();

		foreach($son_list as $key => $value){
			$grandson_list = User::where('parent_id',$value['id'])->orderBy('id', 'asc')->get()->toArray();
			$son_list[$key]['grandson'] = $grandson_list;
		}

		return view('home.user.userNetwork',array('user' => $user,'son_list' => $son_list));
	}

	public function adminUserNetwork($id = 0,$keyword = ''){
		// var_dump($keyword);
		// var_dump($id);exit;
		if($id){
			$user = User::find($id);
		}else if(!empty($keyword)){
			$user = User::where('name','like','%'.$keyword.'%')->first();
		}else{
			$user = AuthUser::user();
		}

		$user_id = $user['id'];

		$son_list = User::where('parent_id',$user_id)->orderBy('id', 'asc')->get()->toArray();

		foreach($son_list as $key => $value){
			$grandson_list = User::where('parent_id',$value['id'])->orderBy('id', 'asc')->get()->toArray();
			$son_list[$key]['grandson'] = $grandson_list;
		}

		return view('home.user.adminUserNetwork',array('user' => $user,'son_list' => $son_list,'keyword' => $keyword));

		// if(!empty($keyword)){
		// 	$user = User::where('name','like','%'.$keyword.'%')->first();
		// }else{
		// 	$user = AuthUser::user();
		// }
		// $user_id = $user['id'];
		//
		// $str = $this->getUserNet($user_id);
		//
		// return view('home.user.adminUserNetwork',array('user' => $user,'str' => $str,'keyword' => $keyword));
	}

	//获取用户递归列表
	public function getUserNet($user_id){
		$son_list = User::where('parent_id',$user_id)->orderBy('id', 'asc')->get()->toArray();

		$str = '';
		foreach($son_list as $key => $value){
			$str .= '<div class="col-lg-4 col-xs-4">'.
				'<div class="middle_son">'.
					'<div class="panel panel-primary">'.
						'<div class="panel-heading">'.
							$value['name'].
						'</div>'.
						'<div class="panel-body">'.
							'<p>等级：<span>'.$value['rank'].'</span></p>'.
						'</div>'.
						'<div class="panel-footer">'.
						'</div>'.
					'</div>'.
				'</div>'.
				'<div class="middle">'.
					'<img src="'.asset('/home/images/network.png').'" width="100%" height="50" />'.
				'</div>'.
				'<div class="row">';

			$str .= $this->getUserNet($value['id']);

			$str .= '</div>'.
			'</div>';
		}
		return $str;
	}

	public function getUserChildren($user_id,&$user_array = array(),$keyword = '',$is_ids = false){
		$son_list = User::where('parent_id',$user_id)->orderBy('id', 'asc')->get();

		foreach($son_list as $key => $value){
			if(!empty($keyword)){
				if(strpos($value->name,$keyword) !== false){
					if($is_ids){
						$user_array[] = $value->id;
					}else{
						$user_array[] = $value;
					}
				}
			}else{
				if($is_ids){
					$user_array[] = $value->id;
				}else{
					$user_array[] = $value;
				}
			}

			$this->getUserChildren($value['id'],$user_array,$keyword,$is_ids);
		}
		return $user_array;
	}

	// function get_array($id=0){
	//     $sql = "select id,title from class where pid= $id";
	//     $result = mysql_query($sql,$conn);//查询子类
	//     $arr = array();
	//     if($result && mysql_affected_rows()){//如果有子类
	//         while($rows=mysql_fetch_assoc($result)){ //循环记录集
	//             $rows['list'] = get_array($rows['id']); //调用函数，传入参数，继续查询下级
	//             $arr[] = $rows; //组合数组
	//         }
	//         return $arr;
	//     }
	// }
// $list = get_array(0); //调用函数
// print_r($list); //输出数组





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

}
