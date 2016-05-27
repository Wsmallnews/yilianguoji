<?php
namespace App;

use Session;

class InviteCode extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('u_id', 'use_id', 'invi_code');


	public function checkInviCode($code){
		$u_id = Session::get('laravel_user_id');
		$result = $this->where('invi_code',$code)->where('u_id',$u_id)->where('status',0)->first();

		return $result;
	}
}
