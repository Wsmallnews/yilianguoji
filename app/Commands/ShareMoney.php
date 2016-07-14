<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use \Exception;
use Log;
use App\CronLog;
use App\User;
use Hp;

class ShareMoney extends Command implements SelfHandling {

	private $type;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($type)
	{
		$this->type = $type;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		//平分奖励
		if($this->type == 1){
			$cronLog = new CronLog();

			$today_date = date('Y-m-d');
			$yestoday_date = date('Y-m-d',(time() - 3600*24));

			$lastLog = $cronLog->where('type','1')->orderBy('id','desc')->first();

			if($lastLog){
				$last_log_time = strtotime($lastLog->days);
				$next_log_date = date('Y-m-d',($last_log_time + 3600*24));
				if($next_log_date > $yestoday_date){
					return;
				}
			}else{
				//第一次执行，数据库为空时，会执行这里
				$cronLog->today_money = 0;
				$cronLog->user_count = 0;
				$cronLog->every_money_json = json_encode(array('every_money' => 0));
				$cronLog->days = $today_date;
				$cronLog->real_share_money = 0;
				$cronLog->type = 1;
				$cronLog->save();
				return;
			}

			$where['status'] = 1;	//必须是已经激活的用户
			$user_list = User::where($where)->get();

			//总会员数
			$user_count = count($user_list);

			//获取公司今日新增业绩
			$user_today_count = User::where($where)->where('invi_at','like',$next_log_date."%")->count();

			$today_money = $user_today_count * app('l_web')->active_money;

			//今日需要平分金额
			$share_money = $today_money * app('l_web')->share_money_scale;
			$every_money = Hp::str_float($share_money / $user_count);	//每人应得金额

			if($today_money < app('l_web')->low_share_money || $every_money <= 0){
				//如果今日公司新增业绩小于low_share_money或者每人应分配金额小于等于0，就不进行平分操作，直接进行日志记录
				$cronLog->today_money = $today_money;
				$cronLog->user_count = $user_count;
				$cronLog->every_money_json = json_encode(array('every_money' => 0));
				$cronLog->days = $next_log_date;
				$cronLog->real_share_money = 0;
				$cronLog->type = 1;
				$cronLog->save();
				return;
			}else{
				$wallet = new Wallet();

				//平分上线 ,激活金额*平分上线(每人累计最多平分金额)
				$max_money = app('l_web')->active_money * app('l_web')->get_money_scale;

				DB::beginTransaction();

				try{
					$real_share_money = 0;
					foreach($user_list as $key => $value){
						$this_user_id = $value->id;
						if($value->get_money >= $max_money){
							continue;	//该用户已达到平分上线
						}

						//每人最多达到max_money，再不修改配置的情况下，不会超过这个值
						$every_money = ($max_money - $value->get_money) > $every_money ? $every_money : ($max_money - $value->get_money);

						$u_wallet = $wallet->findorFail($value->id);

						$result = $u_wallet->increaseMoney($every_money,3);
						if(!$result){
							throw new Exception("平分奖励-钱包编辑失败，用户id为：".$u_wallet->id."日志结束");
						}

						//编辑用户get_money
						$value->get_money = $value->get_money + $every_money;
						$value->save();

						$real_share_money += $every_money;
					}

					//记录日志
					$cronLog->today_money = $today_money;
					$cronLog->user_count = $user_count;
					$cronLog->every_money_json = json_encode(array('every_money' => $every_money));
					$cronLog->days = $next_log_date;
					$cronLog->real_share_money = $real_share_money;
					$cronLog->type = 1;
					$result = $cronLog->save();

					DB::commit();
					return;
				}catch(Exception $e){
					Log::info('catchError',['message',$e->getMessage()]);
					DB::rollback();
					return;
				}
			}
		}else if($this->type == 2){
			$cronLog = new CronLog();

			$today_date = date('Y-m-d');
			$yestoday_date = date('Y-m-d',(time() - 3600*24));

			$lastLog = $cronLog->where('type','2')->orderBy('id','desc')->first();
			if($lastLog){
				$last_log_time = strtotime($lastLog->days);
				$next_log_date = date('Y-m-d',($last_log_time + 3600*24));

				if($next_log_date > $yestoday_date){
					return;
				}
			}else{
				//第一次执行，数据库为空时，会执行这里
				$cronLog->today_money = 0;
				$cronLog->user_count = 0;
				$cronLog->every_money_json = json_encode(array(array('rank' => 0,'share_rank_money' => 0,'user_rank_count' => 0,'every_money' => 0)));
				$cronLog->days = $today_date;
				$cronLog->real_share_money = 0;
				$cronLog->type = 2;
				$cronLog->save();
				return;
			}

			$where['status'] = 1;	//必须是已经激活的用户;
			$user_list = User::where('status',1)->where('rank','>=','3')->orderBy('rank','asc')->get();

			$user_rank_list = array();
			foreach($user_list as $key => $value){
				$user_rank_list[$value->rank][] = $value;
			}

			//总会员数
			$user_count = count($user_list);

			//获取公司今日新增业绩
			$user_today_count = User::where($where)->where('invi_at','like',$next_log_date."%")->count();

			$today_money = $user_today_count * app('l_web')->active_money;

			if($today_money < app('l_web')->low_share_money){
				//如果今日公司新增业绩小于low_share_money，就不进行评分操作，直接进行日志记录
				$cronLog->today_money = $today_money;
				$cronLog->user_count = $user_count;
				$cronLog->every_money_json = json_encode(array(array('rank' => 0,'share_rank_money' => 0,'user_rank_count' => 0,'every_money' => 0)));
				$cronLog->days = $next_log_date;
				$cronLog->real_share_money = 0;
				$cronLog->type = 2;
				$cronLog->save();
				return true;
			}else{
				$wallet = new Wallet();

				try{
					$real_share_money = 0;
					$every_money_array = array();
					foreach($user_rank_list as $key => $value){
						if($key < 3){
							continue;
						}

						$rank = $key > 8 ? 8 : $key;

						switch($rank){
							case 3 :
								$scale = '0.03';
								break;
							case 4 :
								$scale = '0.025';
								break;
							case 5 :
								$scale = '0.02';
								break;
							case 6 :
								$scale = '0.015';
								break;
							case 7 :
								$scale = '0.01';
								break;
							case 8 :
								$scale = '0.005';
								break;
							default :
								$scale = '0';
								break;
						}

						$share_rank_money = $today_money * $scale;

						$user_rank_count = count($value);

						$every_money = Hp::str_float($share_rank_money / $user_rank_count);	//每人应得金额
						if($every_money > 0){
							foreach($value as $k => $v){
								$u_wallet = $wallet->findorFail($v->id);

								$result = $u_wallet->increaseMoney($every_money,5);
								if(!$result){
									throw new Exception("等级平分奖励-钱包编辑失败，用户id为：".$u_wallet->id."日志结束");
								}
								$real_share_money += $every_money;
							}
						}

						$every_money_array[] = array(
							'rank' => $rank,
							'share_rank_money' => $share_rank_money,
							'user_rank_count' => $user_rank_count,
							'every_money' => $every_money,
						);
					}

					//记录日志
					$cronLog->today_money = $today_money;
					$cronLog->user_count = $user_count;
					$cronLog->every_money_json = json_encode($every_money_array);
					$cronLog->days = $next_log_date;
					$cronLog->real_share_money = $real_share_money;
					$cronLog->type = 2;
					$cronLog->save();

					DB::commit();
					return;
				}catch(Exception $e){
					Log::info('catchError',['message',$e->getMessage()]);
					DB::rollback();
					return;
				}
			}
		}
	}

}
