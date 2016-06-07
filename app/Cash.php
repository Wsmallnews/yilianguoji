<?php
namespace App;

class Cash extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('u_id', 'money', 'fail_msg','status');

	protected $table = 'cashs';

	public static function addRole(){
	    return [
	        'money' => 'min:0',
	    ];
	}

	public static function addRoleMsg(){
	    return [
	        'money.min' => '提现金额必须大于0',
	    ];
	}


	//关联用户
	public function user(){
        return $this->belongsTo('App\User','u_id');
	}
}
