<?php
namespace App\Http\Controllers\home;

use App\Setting;
use Request;
use Validator;
use Redirect;
use Session;
use Response;
use DB;

class SettingController extends CommonController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('home');
		$this->middleware('admin');
	}


    public function setting() {
		$setting = Setting::findOrFail(1);

        return view('home.setting.setting',array('setting'=>$setting));
    }

    public function doEdit() {

        $data = Request::input();

        $validate = Validator::make($data,Setting::editRole(),Setting::editRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withInput(Request::input())->withErrors($validate->errors());
        }

		$setting = Setting::find(1);
		$setting->fill($data);
        $setting->save();

		return redirect('home/index');
    }
}
