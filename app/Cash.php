<?php
namespace App;

class Cash extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('u_id', 'money', 'charge_money', 'card_type', 'card_bank', 'card_name', 'card_no','status');

	protected $table = 'cashs';

	public static function addRole(){
	    return [
	        'money' => 'min:0',
	    ];
	}

	public static function addRoleMsg(){
	    return [
	        'money.min' => '提现金额必须大于0',
	    ];
	}


	//关联用户
	public function users(){
        return $this->belongsTo('App\User','u_id');
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
}
