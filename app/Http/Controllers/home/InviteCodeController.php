<?php
namespace App\Http\Controllers\home;

// use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Eloquent\Model;
use App\InviteCode;
use Hp;
use View;
use Request;
use Response;

class InviteCodeController extends CommonController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
// 		$this->middleware('home');
	}

    /**
     * 获取邀请码列表
     */
	public function lists($status = '-1', $u_id = 0){
	    if(Request::ajax){
	        $where = array();
	        if($status >= 0){
	            $where['status'] = $status;
	        }

	        if($u_id){
	            $where['u_id'] = $u_id;
	        }

	        $list = InviteCode::where($where)->get();
	        $r = Hp::rt('ok',1);
	        $r['list'] = $list;
	        Response::json($r);
	    }


	    view('home.inviteCode.lists');
	}

	/**
	 *
	 * @param number $u_id 用户id
	 * @param number $num  生成数量
	 */
	public function createGive($u_id = 0,$num = 1){
	    $library[] = 'ABCDEFGHJKMNPQRSTUVWXYZABC';
	    $library[] = 'abcdefghjkmnpqrstuvwxyzabc';
	    $library[] = '12345678901234567890123456';

	    $success = true;

	    //InviteCode::beginTransaction();
	    for($i = 0; $i < $num; $i++){
    	    do{
    	        //生成唯一验证码str
        	    $str = '';
        	    for($j = 0; $j < 8; $j++ ){
        	        $type = mt_rand(0, 2);
        	        $first = mt_rand(0,25);
        	        $str .= substr($library[$type],$first,1);
        	    }

        	    $count = InviteCode::where('invi_code' , $str)->count();
    	    }while($count > 0);

    	    //将验证码存入数据库
    	    $code['invi_code'] = $str;
    	    if($u_id){
    	        $code['u_id'] = $u_id;
    	    }

    	    $code = InviteCode::create($code);

    	    print_r($code);exit;
    	    if(!$code){
    	        $success = false;
    	        break;
    	    }
    	    echo $str;
	    }

// 	    if($success){
// 	        InviteCode::commit();
// 	    }else{
// 	        InviteCode::rollback();
// 	    }

	    return $success;
	}

}
