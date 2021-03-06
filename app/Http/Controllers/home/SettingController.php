<?php
namespace App\Http\Controllers\home;

use App\Setting;
use Request;
use Validator;
use Redirect;
use Session;
use Response;
use DB;
use Event;
use App\Events\LogEvent as AdminLog;

class SettingController extends CommonController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function _initialize()
	{
		//$this->middleware('home');
		//$this->middleware('admin');
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

		// 使用验证规则，不正常，改用直接验证
		// if($data['repeat_scale'] > 1 || $data['repeat_scale'] < 0){
		// 	return Redirect::back()->withInput($data)->withErrors('重消比例必须大于0，并且小于1');
		// }

		$setting = Setting::find(1);
		$setting->fill($data);

        $setting->save();

		$log_data = array(
			'log_info' => '系统设置：设置成功',
		);
		Event::fire(new AdminLog($log_data));

		return redirect('home/index')->withSuccess('设置成功');
    }
}
