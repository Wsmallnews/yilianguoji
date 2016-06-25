<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use App\User;
use App\Wallet;
use DB;

class SeePrize extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;
	public $id;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($id)
	{
		$this->id = $id;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		//见点奖
		$see_prize = app('l_web')->see_prize * app('l_web')->repeat_scale;
		//直推奖
		$direct_prize = app('l_web')->direct_prize * app('l_web')->repeat_scale;

		$user = new User();

		$userinfo = $user->find($this->id);

		$five_parent = array();
		//父级
		$userinfoP = $user->find($userinfo['parent_id']);
		//$five_parent[] = $userinfoP->id;	//报错，Trying to get property of non-object
		$five_parent[] = $userinfoP['id'];	//获取id

		//祖父级
		$userinfoSec = $user->find($userinfoP['parent_id']);
		$five_parent[] = $userinfoSec['id'];	//获取id

		//三级
		$userinfoThir = $user->find($userinfoSec['parent_id']);
		$five_parent[] = $userinfoThir['id'];	//获取id

		//四级
		$userinfoFour = $user->find($userinfoThir['parent_id']);
		$five_parent[] = $userinfoFour['id'];	//获取id

		//五级
		$userinfoFif = $user->find($userinfoFour['parent_id']);
		$five_parent[] = $userinfoFif['id'];	//获取id

		$wallet = new Wallet();

		DB::beginTransaction();
		try{
			//一级直推奖励
			$parent_wallet = $wallet->findorFail($userinfoP['id']);

			$result = $parent_wallet->increaseMoney($direct_prize,1);
			if(!$result){
				throw new Exception("钱包编辑失败");
			}

			//五级见点奖励
			foreach($five_parent as $key => $value){
				if(!empty($value)){
					$see_wallet = $wallet->findorFail($value);

					$result = $see_wallet->increaseMoney($see_prize,2);
					if(!$result){
						throw new Exception("钱包编辑失败");
					}
				}
			}
			DB::commit();
			return true;
		}catch(Exception $e){
			DB::rollback();
			return false;
		}

	}

}
