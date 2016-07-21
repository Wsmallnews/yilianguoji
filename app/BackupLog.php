<?php
namespace App;

class BackupLog extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('days', 'use_time', 'is_auto');

	public function scopeAuto($query){
		return $this->where('is_auto',1);
	}


}
