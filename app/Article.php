<?php
namespace App;

class Article extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('title', 'description', 'content', 'is_top');

	//完善资料验证
	public static function addEditRole(){
	    return [
	        'title' => 'required',
	        'description' => 'required',
	        'content' => 'required',
	    ];
	}

	public static function addEditRoleMsg(){
	    return [
	        'title.required' => '文章标题不能为空',
            'description.required' => '描述不能为空',
            'content.required' => '内容不能为空',
	    ];
	}

	public function scopeTop($query){
		return $this->where('is_top',1);
	}




}
