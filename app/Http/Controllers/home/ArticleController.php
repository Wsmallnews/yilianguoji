<?php
namespace App\Http\Controllers\home;

use Request;
use Validator;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\Wallet;
use App\User;
use App\Article;
use DB;
use \Exception;
use Event;
use App\Events\LogEvent as AdminLog;

class ArticleController extends CommonController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function _initialize()
	{
		//$this->middleware('home');
	}

	public function view($id = 0){
		$article = Article::find($id);

		return view('home.article.view',array('article' => $article));
	}

	public function lists(){
		$data = Request::all();

	    $pageRow = isset($data['rows']) ? $data['rows'] : 15;

		$article = new Article();

		if(!empty($data['keyword'])){
			$article = $article->where('title', 'like', '%'.$data['keyword'].'%');
		}

        $article_list = $article->orderBy('id','desc')->paginate($pageRow);

		if(Request::ajax()){

	        $view = view('home.article.li',array('article_list' => $article_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));
	    }else{
	        return view('home.article.adminLists',array('article_list' => $article_list));
	    }
	}


	/**
	 * 管理员文章列表
	 *
	 * @return Response
	 */
	public function adminLists() {
		$data = Request::all();

	    $pageRow = isset($data['rows']) ? $data['rows'] : 15;

		$article = new Article();
		if(!empty($data['keyword'])){
			$article = $article->where('title', 'like', '%'.$data['keyword'].'%');
		}

        $article_list = $article->orderBy('id','desc')->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.article.adminLi',array('article_list' => $article_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.article.adminLists',array('article_list' => $article_list));
	    }
	}

    public function add() {

		$article = new Article();

        return view('home.article.add',array('article' => $article,'title' => '添加'));
    }

	public function edit($id = 0){
		$article = Article::find($id);

		return view('home.article.add',array('article' => $article,'title' => '修改'));
	}

    public function doAddEdit() {
        $data = Request::all();

		if(empty($data['description'])){
			$data['description'] = mb_substr($data['content'],0,200,'utf-8');
		}

		if(!isset($data['is_top'])){
			$data['is_top'] = 0;
		}

		$validate = Validator::make($data,Article::addEditRole(),Article::addEditRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withInput($data)->withErrors($validate->errors());
        }

		DB::beginTransaction();
		try{

			$article = new Article();

			if($data['id']){
				$article = $article->find($data['id']);
			}

			$article->fill($data);

			$article->save();

			$log_data = array(
				'log_info' => '资讯：添加/编辑成功【id：'.$article->id."】",
			);
			Event::fire(new AdminLog($log_data));

			DB::commit();

	        return redirect()->intended('home/adminArticleList')->withSuccess('文章保存成功');

		}catch(Exception $e){
			print_r($e->getMessage());
			DB::rollback();
			// return Redirect::back()->withInput(Request::all())->withErrors('文章保存失败');
		}
    }

}
