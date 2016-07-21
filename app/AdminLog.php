<?php
namespace App;

class AdminLog extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('u_id', 'log_info', 'ip_address');

	//关联用户
	public function users(){
        return $this->belongsTo('App\User','u_id');
	}
}
