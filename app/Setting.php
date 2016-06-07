<?php
namespace App;

use Session;

class Setting extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('web_name', 'active_money');

	public $timestamps = false;

	public static function editRole(){
	    return [
	        'web_name' => 'required',
	        'active_money' => 'min:0'
	    ];
	}

	public static function editRoleMsg(){
	    return [
	        'web_name.required' => '网站名称必须填写',
	        'active_money.min' => '激活亿联币必须大于0'
	    ];
	}
}
