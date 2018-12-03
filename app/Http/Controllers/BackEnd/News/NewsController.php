<?php
namespace App\Http\Controllers\BackEnd\News;

use App\Http\Controllers\BackendController;
use App\Models\BackEnd\News\NewsCategoryModel;
use Illuminate\Http\Request;
use App\Models\BackEnd\News\NewsModel;
use App\libraries\Firebase;
use Config;

class NewsController extends BackendController
{

	public function __construct()
	{
		parent::__construct();
		$this->messages = Config::get('constant');
		$this->newsCategory = new NewsCategoryModel();
		$this->news = new NewsModel();
		$this->firebase = new Firebase();
	}

	public function getIndex()
	{
		return view($this->viewFolder . '.news.news.index')->with($this->data);
	}

	public function postIndex(Request $request)
	{
		return $this->news->getDataGrid($request->all());
	}

	public function postNew(Request $request)
	{
		return $this->loadView($request);
	}

	public function postEdit(Request $request)
	{
		return $this->loadView($request);
	}

	private function loadView(Request $request)
	{
		$this->data['row'] = $this->news->getDataByRowId($request['Id']);
		$this->data['list_news_category'] = json_encode($this->news->getAllCategories());
		$this->data['list_news_tag'] = json_encode($this->news->getAllNewsTag());
		return view($this->viewFolder . '.news.news.new')->with($this->data);
	}

	public function postSave(Request $request)
	{
		$title = mb_strlen ($request->title)>200? mb_substr($request->title, 0, 200).'...':$request->title;
		$short_des = mb_substr($request->short_description, 0, 200)."...";
		$id = $this->news->postSave($request->all());
		if ($request->Id==0&& $id!=0 && $request->is_mef_news==1) $this->broadcastNews($id , $title, $short_des);
		return json_encode(array("code" => 1, "message" => $this->messages['success'], "data" => ""));
	}

	public function postDelete(Request $request)
	{
		$listId = isset($request['Id']) ? $request['Id'] : '';
		return $this->news->postDelete($listId);
	}

	private function broadcastNews($id, $title, $short_description){
		//blog array variable
		$payload = array();
		$payload['develope_by'] = 'MEF';
		$payload['version'] = '01';
		//firebase notification structure
		$data = array(
			"title"=>$title,
			"body"=> $short_description,
			"data"=>[
				"news_id"=>$id
			]
		);

		$res = $this->firebase->sendToTopic(env('PUSH_NOTIFICATION','dev'), $data);
	}

}
