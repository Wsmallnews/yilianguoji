<?php
namespace App;

class RechargeLog extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('u_id', 'money');

	//关联用户
	public function users(){
        return $this->belongsTo('App\User','u_id');
	}

}
