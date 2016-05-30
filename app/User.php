<?php
namespace App;

use AuthUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends CommonModel{
    use SoftDeletes;

    protected $softDelete  = true;

    protected $dates = ['delete_at'];

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $hidden = ['password'];	//不出现在 数组或 JSON 格式的属性数据

	protected $fillable = array('nick_name', 'email', 'password', 'phone', 'gender', 'birth', 'real_name', 'cert_no', 'card_type', 'card_no');

	//登录验证
	public static function loginRole(){
	    return [
	        'name' => 'required|exists:users',
	        'password' => 'required'
	    ];
	}

	public static function loginRoleMsg(){
	    return [
	        'name.required' => '请输入用户名',
	        'name.exists' => '用户名不存在',
	        'password.required' => '请输入密码'
	    ];
	}

	//注册验证
	public static function addRole(){
	    return [
            'name' => 'required|unique:users',
	        // 'nick_name' => 'required',
	        'email' => 'required|email',
	        'password' => 'required',
            'confirmPassword' => 'required|same:password',
	        'phone' => 'required|unique:users',
	        'gender' => 'required',
	        'birth' => 'required',
	        'real_name' => 'required',
	        'cert_no' => 'required',
	        'card_type' => 'required',
	        'card_no' => 'required',
            'parent_id' => 'required'
	    ];
	}

	public static function addRoleMsg(){
	    return [
            'name.required' => '用户名不能为空',
            'name.required' => '用户名已存在，请重新输入',
	        // 'nick_name.required' => '用户昵称不能为空',
	        'email.required' => '邮箱不能为空',
	        'email.email' => '邮箱格式不正确',
	        'password.required' => '密码不能为空',
            'confirmPassword.required' => '两次输入密码不一致',
            'confirmPassword.same' => '两次输入密码不一致',
	        'phone.required' => '手机号不能为空',
	        'phone.unique' => '手机号已存在',
	        'gender.required' => '性别必须选择',
	        'birth.required' => '生日不能为空',
	        'real_name.required' => '真实姓名不能为空',
	        'cert_no.required' => '身份证号不能为空',
	        'card_type.required' => '账户类型必须选择',
	        'card_no.required' => '银行账户不能为空',
            'parent_id.required' => '必须有邀请人'
	    ];
	}

	//获取一条邀请码
	public function getOneInviCode($code = ''){
        if(!empty($code)){
            return $this->hasMany('App\InviteCode','u_id')->where('invi_code',$code)->where('status',0);
        }else{
            return $this->hasMany('App\InviteCode','u_id')->where('status',0);
        }

	}


	//获取所有支出队列
	public function getAllOutQueue(){
	    return $this->hasMany('App\OutQueue','u_id');
	}


	/*封号*/
	public function lockUser(){

	    $user = AuthUser::user();
	    $user->delete();

	    if(!$user->trashed()){
	        return false;
	    }
	    return true;
	}





}
