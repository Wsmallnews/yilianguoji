<?php
namespace App;

class Article extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('title', 'description', 'content', 'is_top');


	public function scopeTop($query){
		return $this->where('is_top',1);
	}

	
}
