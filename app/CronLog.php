<?php
namespace App;

class CronLog extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('today_money', 'user_count', 'share_money','exec_time','days');

}
