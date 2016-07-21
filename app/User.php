<?php
namespace App;

use AuthUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Exception;

class User extends CommonModel{
    use SoftDeletes;

    protected $softDelete  = true;

    protected $dates = ['delete_at'];

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $hidden = ['password'];	//不出现在 数组或 JSON 格式的属性数据

	protected $fillable = array('name','parent_id','nick_name', 'direct_id', 'email', 'password', 'phone', 'gender', 'birth', 'real_name', 'cert_no', 'card_type', 'card_bank', 'card_name', 'card_no');

	//登录验证
	public static function loginRole(){
	    return [
	        'name' => 'required|exists:users',
	        'password' => 'required'
	    ];
	}

	public static function loginRoleMsg(){
	    return [
	        'name.required' => '请输入用户名',
	        'name.exists' => '用户名不存在',
	        'password.required' => '请输入密码'
	    ];
	}

    public static function addFastRole(){
        return [
            'name' => 'required|unique:users',
	        'password' => 'required',
            'confirmPassword' => 'required|same:password',
            'parent_id' => 'required',
            'direct_id' => 'required'
	    ];
    }

    public static function addFastRoleMsg(){
	    return [
            'name.required' => '用户名不能为空',
            'name.unique' => '用户名已存在，请重新输入',
	        'password.required' => '密码不能为空',
            'confirmPassword.required' => '两次输入密码不一致',
            'confirmPassword.same' => '两次输入密码不一致',
            'parent_id.required' => '必须有接点人',
            'direct_id.required' => '必须有推荐人',
	    ];
	}

	//完善资料验证
	public static function editRole($id){
	    return [
	        'email' => 'email|unique:users,email,'.$id,
	        'phone' => 'regex:/^1\d{10}$/|unique:users,phone,'.$id,
	        // 'real_name' => 'required',
	        // 'cert_no' => 'required',
	        // 'card_type' => 'required',
	        // 'card_no' => 'required',

	    ];
	}

	public static function editRoleMsg(){
	    return [
	        // 'email.required' => '邮箱不能为空',
	        'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱已存在，请重新输入',
	        // 'phone.required' => '手机号不能为空',
            'phone.regex' => '手机号格式不正确',
            'phone.unique' => '手机号已存在，请重新输入',
	        // 'real_name.required' => '真实姓名不能为空',
	        // 'cert_no.required' => '身份证号不能为空',
	        // 'card_type.required' => '账户类型必须选择',
	        // 'card_no.required' => '银行账户不能为空',
	    ];
	}

	//获取一条邀请码
	// public function getOneInviCode($code = ''){
    //     if(!empty($code)){
    //         return $this->hasMany('App\InviteCode','u_id')->where('invi_code',$code)->where('status',0);
    //     }else{
    //         return $this->hasMany('App\InviteCode','u_id')->where('status',0);
    //     }
    //
	// }


	//获取所有支出队列
	// public function getAllOutQueue(){
	//     return $this->hasMany('App\OutQueue','u_id');
	// }

    //获取当前用户钱包
	public function getWalletOne(){
	    return $this->hasOne('App\Wallet','id');
	}

    // public function getCode(){
	//     return $this->hasMany('App\InviteCode','u_id');
	// }


    //载入父级信息
    public function parent(){
        return $this->belongsTo('App\User','parent_id');
    }

    //载入推荐人信息
    public function direct(){
        return $this->belongsTo('App\User','direct_id');
    }

    //载入银行名称
    public function bank(){
        return $this->belongsTo('App\Bank','card_bank');
    }

    //载入父级信息
    public function getCardTypeNameAttribute()
    {
        $card_type_name = '';
        if($this->card_type == 1){
            $card_type_name = "支付宝";
        }else if($this->card_type == 2){
            $card_type_name = "银行卡";
        }else if($this->card_type == 3){
            $card_type_name = "微信号";
        }

        return $card_type_name;
    }

    //获取提现记录
    public function cashs(){
        return $this->hasMany('App\Cash','u_id');
    }


    //获取指定上几级用户的id
    public function getParents($level){

        try{
            $u_id = $this->id;
            for($i = 0; $i < $level; $i++){
                $parent = $this->findorFail($u_id);
                $u_id = $parent['parent_id'];
            }
        }catch(Exception $e){
            // $default_user = $this->where('name',app('l_web')->default_user)->first();
            // $u_id = $default_user['id'] ? $default_user['id'] : 0;
            $u_id = 0;
        }

        //验证u_id，因为for循环之后没有确定这个u_id 对应的用户是否被删除
        $result = $this->find($u_id);

        return $result;
    }


	/*封号*/
	public function lockUser(){

	    $user = AuthUser::user();
	    $user->delete();

	    if(!$user->trashed()){
	        return false;
	    }
	    return true;
	}

}
