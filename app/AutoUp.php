<?php
namespace App;

class AutoUp extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('need_money', 'rank');

}
