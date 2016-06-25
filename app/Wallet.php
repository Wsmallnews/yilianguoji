<?php
namespace App;
use DB;
use AuthUser;
use \Exception;

class Wallet extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('id','money','money_lock');

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

	public function doAdd($id){
		$this->id = $id;
		$this->money = 0;
		$this->money_lock = 0;
		return $this->save();
	}


	//直接增加
	public function increaseMoney($money,$type_id){
		DB::beginTransaction();
		$user = AuthUser::user();
		$this->money = $this->money + $money;

		try {
			$result = $this->save();

			$walletLog = new WalletLog();
			$walletLog->u_id = $this->id;
			$walletLog->type_id = $type_id;
			$walletLog->type = $type_id == 4 ? ($this->getType($type_id)."：用户名为“".$user->name."”的用户自助升级") : $this->getType($type_id);
			$walletLog->money = $money;
			$walletLog->status = 1;
			$result = $walletLog->save();

			DB::commit();
			return true;
		}catch(Exception $e) {
			DB::rollback();

			return false;
		}
	}

	//直接减去
	public function reduceMoney($money,$type_id){
		DB::beginTransaction();

		try {
			$this->money = $this->money - $money;

			if($this->money < 0){
				throw new Exception("钱包余额不足，请进行充值");
			}

			$result = $this->save();

			$walletLog = new WalletLog();
			$walletLog->u_id = $this->id;
			$walletLog->type_id = $type_id;
			$walletLog->type = $this->getType($type_id);
			$walletLog->money = $money;
			$walletLog->status = 1;
			$result = $walletLog->save();

			DB::commit();
			return true;
		}catch(Exception $e) {
			DB::rollback();
			return false;
		}
	}

	//减少余额，增加锁定余额，虚拟减少，不记录日志，处理成功记录钱包日志
	public function virtualReduceMoney($money){
		//减少可用余额
		$this->money = $this->money - $money;

		if($this->money < 0){
			return false;
		}

		//增加锁定余额
		$this->money_lock = $this->money_lock + $money;

		$result = $this->save();

		return $result;
	}

	//真实减少锁定余额
	public function realReduceMoney($money,$type_id){
		DB::beginTransaction();

		try {
			//减少锁定余额
			$this->money_lock = $this->money_lock + $money;

			if($this->money_lock < 0){
				throw new Exception("钱包锁定余额不足");
			}

			$result = $this->save();

			$walletLog = new WalletLog();
			$walletLog->u_id = $this->id;
			$walletLog->type_id = $type_id;
			$walletLog->type = $this->getType($type_id);
			$walletLog->money = $money;
			$walletLog->status = 1;
			$result = $walletLog->save();

			DB::commit();
			return true;
		}catch(Exception $e) {
			DB::rollback();

			return false;
		}
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
			case 4 :
				$type = '互助奖励';
				break;
			case -1 :
				$type = '提现';
				break;
			case -2 :
				$type = '激活用户';
				break;
			case -3 :
				$type = '自助升级';
				break;
			default :
				$type = '未知';
				break;
		}
		return $type;
	}
}
