<?php
namespace App\Http\Controllers\home;

use Request;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\Wallet;

class WalletController extends CommonController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('home');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function wallet() {
		$wallet = AuthUser::user()->getWalletOne()->first();

		return view('home.wallet.wallet',array('wallet' => $wallet));
	}




}
