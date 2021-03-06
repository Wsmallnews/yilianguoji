<?php
namespace App\Http\Controllers\home;

use App\User;
use Request;
use Validator;
use Redirect;
use AuthUser;
use App\Wallet;
use App\Setting;
use App\WalletLog;
use Session;
use Hp;
use DB;
use \Exception;
use Queue;
use App\Commands\SeePrize;
use App\Commands\ShareMoney;
use App\Commands\DBbackup;
use Bus;
use Artisan;
use App\Article;
use App\Cash;
use Event;
use App\Events\LogEvent as AdminLog;
use Storage;

class IndexController extends CommonController {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function _initialize()
	{

		//$this->middleware('home');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

		// $cash = new Cash();
		// $users = AuthUser::user()->cashs()->first();
		//
		// print_r($users);
		// exit;
		// try{
		// 	$user = Wallet::findOrFail(123);
		// 	if($user->money != 0){
		// 		throw new Exception('该申请已处理，不需再次处理');
		// 	}
		// }catch(Exception $e){
		// 	print_r($e->getMessage());
		// }
		// $a = 'smallnews';
		// echo bcrypt('smallnews').'<br>';
		// echo bcrypt($a).'<br>';
		// exit;
		// try{
		// 	$mgr = new CommandManager();
		// 	$cmd = $mgr->getCommandObject("realcommand");
		// 	$cmd->execute();
		// }catch (Exception $e){
		// 	echo "fail";
		// }
		// exit;
		// return;
		// DB::beginTransaction();
		// try{
		// 	$wallet = Wallet::findOrFail(1000000);
		//
		// 	$wallet->money = 300;
		// 	$wallet->save();
		//
		// 	$walletLog = new WalletLog();
		// 	$walletLog->u_id = 1;
		// 	$walletLog->type_id = 2;
		// 	$walletLog->type = 1;
		// 	$walletLog->money = 300;
		// 	$walletLog->status = 1;
		// 	$walletLog->save();
		//
		// 	DB::commit();
		// }catch(Exception $e){
		// 	DB::rollback();
		//
		// 	echo "失败";
		// 	print_r($e);
		// }exit;
		$article = Article::orderBy('is_top','desc')->orderBy('id','desc')->paginate(10);

	    return view('home.index.index',array('article' => $article));
	}


	public function login()
	{
		// echo env('DB_HOST')."host<br>";
		// echo env('DB_DATABASE')."db<br>";
		// echo env('DB_USERNAME')."us<br>";
		// echo env('DB_PASSWORD')."ps<br>";
		// echo env('CACHE_DRIVER')."cache<br>";
		// echo env('MAIL_DRIVER')."mail<br>";
		// echo env('MAIL_HOST')."mhost<br>";
		// echo env('MAIL_PORT')."port<br>";
	    return view('home.login');
	}


	public function doLogin(){

        $data = Request::all();

        $validate = Validator::make($data,User::loginRole(),User::loginRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withErrors($validate);
        }

        if (AuthUser::attempt($data)){
			$log_data = array(
				'log_info' => '登录：成功',
			);
			Event::fire(new AdminLog($log_data));
			//登录成功
            return redirect()->intended('home/index');
        }else{
			$log_data = array(
				'u_id' => '0',
				'log_info' => '登录：失败，密码错误',
			);
			Event::fire(new AdminLog($log_data));

            return Redirect::back()->withInput(Request::except('password'))->withErrors('密码错误');
        }
	}

    //登出
	public function getLogout()
	{
	    AuthUser::logout();
	    return redirect('home/login');
	}


	public function crontab(){
		//shareMoney
		Bus::dispatch(
	        new ShareMoney(1)
	    );
		Bus::dispatch(
	        new ShareMoney(2)
	    );

		//crontab
		Bus::dispatch(
	        new DBbackup()
	    );
	}
}
