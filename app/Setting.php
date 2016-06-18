<?php
namespace App;

use Session;

class Setting extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('web_name', 'active_money', 'direct_prize', 'see_prize', 'repeat_scale');

	public $timestamps = false;

	public static function editRole(){
	    return [
	        'web_name' => 'required',
	        'active_money' => 'required|min:0',
			'direct_prize' => 'required|min:0',
			'see_prize' => 'required|min:0',
			'repeat_scale' => 'required',
	    ];
	}

	public static function editRoleMsg(){
	    return [
	        'web_name.required' => '网站名称必须填写',
	        'active_money.required' => '激活亿联币必须填写',
			'active_money.min' => '激活亿联币必须大于0',
			'direct_prize.required' => '直推奖励必须填写',
			'direct_prize.min' => '直推奖励必须大于0',
			'see_prize.required' => '见点奖必须填写',
			'see_prize.min' => '见点奖必须大于0',
			'repeat_scale.required' => '重消比例必须填写',
			// 'repeat_scale.min' => '重消比例不能小于0',
			// 'repeat_scale.max' => '重消比例不能大于1'
	    ];
	}
}
