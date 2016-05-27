<?php namespace App\Services;

use Illuminate\Contracts\Hp\Hp as HpContract;

class Hp implements HpContract {

	public function rt($info = '',$status = 0){
	    $r['info'] = $info;
	    
	    if(empty($info)){
	        $r['info'] = $status ? '操作成功' : '操作失败';
	    }

	    $r['status'] = $status;

	    return $r;
	}
	

	// 获取二维数组中某一项的集合
	public function zstr_array_column($data, $field){
	    $egt_5_5 = version_compare(PHP_VERSION,'5.5.0','>=');
	    if ($egt_5_5) {
	        $fields = array_column($data, $field);
	    } else {
	        $fields = array_reduce($data, create_function('$v,$w', '$v[]=$w["'.$field.'"];return $v;'));
	    }
	    return $fields;
	}
	
}
