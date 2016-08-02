<?php
namespace App\Http\Controllers\home;

use App\BackupLog;
use Request;
use Redirect;
use Response;
use Storage;


class BackupLogController extends CommonController {

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
	public function lists() {
	    $pageRow = Request::input('rows',15);

        $backup_list = BackupLog::paginate($pageRow);

	    if(Request::ajax()){
	        $view = view('home.backupLog.li',array('backup_list' => $backup_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));
	    }else{
	        return view('home.backupLog.lists',array('backup_list' => $backup_list));
	    }
	}


	// public function backDownLoad($id = 0){
	// 	$backup = BackupLog::find($id);
	//
	// 	if($backup){
	// 		$file = Storage::disk('local')->get("db/".$backup->file_name);
	//
	// 		return response($file, 200)->header('Content-Type','application/octet-stream');
	// 	}
	// }
}
