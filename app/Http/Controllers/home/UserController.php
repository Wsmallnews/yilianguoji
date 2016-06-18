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

        $user_list = User::where($where)->paginate($pageRow);

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

			DB::commit();
			return redirect('home/userList');
		}catch(Exception $e) {
			DB::rollback();
            return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('添加失败');
		}

		// Queue::push(new SeePrize($user->id));
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

			//修改用户为已激活
			$user->status = 1;
			$user->invi_at = date('Y-m-d H:i:s');

			$result = $user->save();

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
		return view('home.user.selfUp');
	}

	public function doSelfUp(){
		return redirect('home/selfUp');
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

	public function createName(){
	    $success = true;

	    do{
	        //生成唯一用户str
    	    $str = 'yl';

    	    $str .= mt_rand(10000000,99999999);

    	    $count = User::where('name' , $str)->count();
	    }while($count > 0);

	    return $str;
	}

}
