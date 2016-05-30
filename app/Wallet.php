<?php
namespace App;

class Wallet extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('money','money_lock');

	public $timestamps = false;

	//操作钱包必须走这个验证(减少)
	public static function AllRole(){
	    return [
	        'money' => 'min:0',
	        'money_lock' => 'min:0'
	    ];
	}

	public static function AllRoleMsg(){
	    return [
	        'money.min' => '余额不足',
	        'money_lock.min' => '余额不足'
	    ];
	}

	//直接增加
	public function increaseMoney($money,$type_id){
		$this->money = $this->money + $money;
		$result = $this->save();

		if($result){
			$walletLog = new WalletLog();
			$walletLog->u_id = $this->id;
			$walletLog->type_id = $type_id;
			$walletLog->type = getType($type_id);
			$walletLog->money = $money;
			$walletLog->status = 1;
			$result = $walletLog->save();
		}

		if ($result){
			DB::commit();
		}else{
			DB::rollback();
		}

		return $result;
	}

	//直接减去
	public function reduceMoney($money,$type_id){
		DB::beginTransaction();
		$this->money = $this->money - $money;

		if($this->money < 0){
			return false;
		}

		$result = $this->save();

		if($result){
			$walletLog = new WalletLog();
			$walletLog->u_id = $this->id;
			$walletLog->type_id = $type_id;
			$walletLog->type = getType($type_id);
			$walletLog->money = $money;
			$walletLog->status = 1;
			$result = $walletLog->save();
		}

		if ($result){
			DB::commit();
		}else{
			DB::rollback();
		}

		return $result;
	}

	//减少余额，增加锁定余额，虚拟减少
	public function virtualReduceMoney($money,$type){

	}

	//真是减少锁定余额
	public function realReduceMoney($money,$type){

	}

	private function getType($type_id){
		switch($type_id){
			case 1 :
				$type = '推荐奖励';
				break;
			case 2 :
				$type = '见点奖励';
				break;
			case 3 :
				$type = '平分奖励';
				break;
			case -1 :
				$type = '提现';
				break;
			case -2 :
				$type = '激活用户';
				break;
			default :
				$type = '未知';
				break;
		}
		return $type;
	}
}
