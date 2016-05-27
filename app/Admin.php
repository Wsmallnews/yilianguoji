<?php 
namespace App;

class Admin extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $hidden = ['password'];	//不出现在 数组或 JSON 格式的属性数据
	
	protected $fillable = array('name','phone', 'email', 'password');
	
	
	public static function loginRole(){
	    return [
	        'name' => 'required|exists:users',
	        'password' => 'required'
	    ];
	}
	
	public static function loginRoleMsg(){
	    return [
	        'name.required' => '请输入手机号',
	        'name.exists' => '用户名不存在',
	        'password.required' => '请输入密码'
	    ];
	}
	
	//测试
// 	public function topic(){
// 	    return $this->hasMany('App\topic','user_id')->orderBy('updated_at','desc');
// 	}

	
	

}