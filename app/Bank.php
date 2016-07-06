<?php
namespace App;

class Bank extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('bank_name', 'is_del');


	public function scopeDel($query){
		return $this->where('is_del',0);
	}
}
