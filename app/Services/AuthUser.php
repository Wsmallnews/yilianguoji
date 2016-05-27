<?php namespace App\Services;

use Illuminate\Contracts\AuthUser\AuthUser as AuthUserContract;
use App\User;
use Session;
use Hash;
class AuthUser implements AuthUserContract {
	//登录
	public function attempt($data){
	    $where = array();

	    $password = $data['password'];

	    unset($data['password'],$data['_token']);

	    $data['name'] = trim($data['name']);
		$data['status'] = 1;	//激活

	    $result = User::where($data)->first();

        if(Hash::check($password,$result['password'])){
            $this->setSession($result->id);
            return true;
        }

	    return false;
	}

	//检测是否登录
	public function check(){
	    if(Session::has('laravel_user_id')){
	        return true;
	    }
	    return false;
	}

	//保存用户信息
	public function setSession($id){
	    Session::put('laravel_user_id',$id);
	}

	//获取用户信息
	public function user(){
	    $result = User::find(Session::get('laravel_user_id'));

	    return $result;
	}

	//登出
	public function logout(){
	    Session::forget('laravel_user_id');
	    return ;
	}


}
