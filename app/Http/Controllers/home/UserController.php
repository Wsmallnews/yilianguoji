<?php
namespace App\Http\Controllers\home;

use App\User;
use Request;
use Validator;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\InviteCode;
use DB;

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
	    $pageRow = Request::input('rows',1);

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
        return view('home.user.add');
    }

    public function doAdd() {
		$inviteCode = new InviteCode();

		DB::beginTransaction();
		$is_active = 0;
        $data = Request::except('confirmPassword');

        $validate = Validator::make($data,User::addRole(),User::addRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors($validate->errors());
        }

        $user = new User($data);

        $user->parent_id = Session::get('laravel_user_id');

        if(!empty($data['invi_code'])){
            //验证激活码
            $result = $inviteCode->checkInviCode($data['invi_code']);
			if($result){
				$inviCode = $result;
				$is_active = 1;
				$user->status = 1;
				$user->invi_at = date('Y-m-d H:i:s');
			}
        }

        $result = $user->save();

		if($result && $is_active){
			// 将邀请码标记为已使用
			$inviteCode->find($inviCode['id']);
			$inviteCode->status = 1;
			$inviteCode->use_id = $result;
			$inviteCode->used_at = date('Y-m-d H:i:s');

			$result = $inviteCode->save();
		}

        if ($result){
			DB::commit();
            return redirect()->intended('home/userList');
        }else{
			DB::rollback();
            return Redirect::back()->withInput(Request::except('password','confirmPassword'))->withErrors('添加失败');
        }
    }


	public function doUserActive(){
		DB::beginTransaction();
		$id = Request::input('id',0);

		$user = User::find($id);

		if($user->status){
			return Response::json(array('error'=>1,'info' => '该用户已激活，不需要重复激活'));
		}

		$code = AuthUser::user()->getOneInviCode()->first();

		if($code){
			$user->status = 1;
			$user->invi_code = $code->invi_code;
			$user->invi_at = date('Y-m-d H:i:s');

			$result = $user->save();

			if($result){
				// 将邀请码标记为已使用
				$code->status = 1;
				$code->use_id = $id;
				$code->used_at = date('Y-m-d H:i:s');
				$result = $code->save();
			}
		}

		if ($result){
			DB::commit();
            return Response::json(array('error'=>0,'info' => '激活成功'));
        }else{
			DB::rollback();
            return Response::json(array('error'=>1,'info' => '激活失败'));
        }
	}

}
