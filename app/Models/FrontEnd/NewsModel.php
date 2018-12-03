<?php

namespace App\Models\FrontEnd;

use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Support\Facades\DB;
use Config;

class NewsModel
{

	public $table = 'mef_news';
	public $default_image = 'files/news/default.jpg';
	public $select = ['news.Id',
		'news.title',
		'mef_news_category_id',
		'image',
		'url as news_url',
		'short_description',
		'is_publish',
		'create_date',
		'cate.name as category_name',
		'cate.icon as category_icon',
		'news.count_read'];

	public function getTagByUserMood($user_mode=1){
		$return = [];
		$result = DB::table('mef_news_tag')->select('Id')->where('user_mood', '>=', $user_mode)->get();
		if (!empty($result)){
			foreach ($result as $row){
				$return[] = $row->Id;
			}
		}
		return $return;
	}

	public function __construct()
	{
		$this->userGuestSession = session('sessionGuestUser');
//		$this->mood = $this->getTagByUserMood(session('feeling_id'));

		$this->officer = 0;
		if ($this->userGuestSession != null) {
			$this->officer = $this->userGuestSession->Id;
		}
		/* Menglay: USER HAS or HASN'T SESSION */
		if($this->userGuestSession == null){
			$this->userGuestSession = session('sessionGuestUserUpdate');
		}
	}

	private function pageProperty($page=null){
		$return = [
			'limit'=>12,
			'offset'=>0
		];
		if ((is_int($page) || ctype_digit($page)) && (int)$page > 0 ){
			$return['offset'] = ($page-1)*$return['limit'];
		}
		return $return;
	}

	public function getAllCategory($id=null){
		$cat = [];
		$return = [];
		$categories = DB::table('mef_news_category')
			->orderBy('order_number', 'asc')
			->orderBy('Id', 'asc')
			->get();
		foreach ($categories as $category){
			if ($category->parent_id!=0){
				$cat[$category->parent_id]->sub[] = $category;
			} else {
				$cat[$category->Id] = $category;
			}
		}
		foreach ($cat as $item){
			$return[]= $item;
		}
		return $return;
	}

	public function getAllTag(){
		$tags = DB::table('mef_news_tag')->orderBy('order_number')->get();
		return $tags;
	}

	public function getLatestNews($page)
	{
		$return = [
			'limit'=>12,
			'offset'=>0
		];
		if ((is_int($page) || ctype_digit($page)) && (int)$page > 0 ){
			$return['offset'] = ($page-1)*$return['limit'];
		}
//		$mood = $this->getTagByUserMood(session('feeling_id'));
		$news = DB::table($this->table . ' as news')
			->select($this->select)
			->join('mef_news_category as cate', 'cate.Id', '=', 'news.mef_news_category_id')
//			->whereIn('mef_news_tag_id',$mood)
			->orderBy('create_date', 'desc')
			->limit($return['limit'])
			->offset($return['offset'])
			->get();
		if (!empty($news)){
			foreach ($news as $new) {
				$new->title = mb_substr($new->title,0,100);
				$new->image = ($new->image!='')?$new->image:$this->default_image;
				$new->short_description = mb_substr($new->short_description,0,200);
			}
		}
		return $news;
	}

	public function getNewsById($id){
		$news = DB::table($this->table.' as news')->where('news.Id',$id)
			->join('mef_news_category as cate', 'cate.Id', '=', 'news.mef_news_category_id')
			->first();
		if ($news!=null){
			$news->image = ($news->image!='')?$news->image:$this->default_image;
		}
		return $news;
	}

	public function getCategoryNameById($id){
		$name = '';
		$cat = DB::table('mef_news_tag')->select('name')->where('Id',$id)->first();
		if ($cat!=null){
			$name = $cat->name;
		}
		return $name;
	}
	public function getListNewsByCategory($id, $page=0){
		$page = $this->pageProperty($page);
		$news = DB::table($this->table . ' as news')
			->select($this->select)
			->join('mef_news_category as cate', 'cate.Id', '=', 'news.mef_news_category_id')
			->where('mef_news_tag_id',$id)
			->orderBy('create_date', 'desc')
			->limit($page['limit'])
			->offset($page['offset'])
			->get();
		if (!empty($news)){
			foreach ($news as $new){
				$new->title = mb_substr($new->title,0,100);
				$new->image = ($new->image!='')?$new->image:$this->default_image;
				$new->short_description = mb_substr($new->short_description,0,200);
			}
		}
		return $news;
	}

	public function getTopNews($id, $num=10){

		$news = DB::table($this->table . ' as news')
			->select($this->select)
			->join('mef_news_category as cate', 'cate.Id', '=', 'news.mef_news_category_id')
			->orderBy('count_read', 'desc')
			->orderBy('create_date', 'desc')
//			->whereIn('mef_news_tag_id',$this->mood)
			->where('news.Id', '<>',$id)
			->limit($num)
			->offset(0)
			->get();
		if (!empty($news)){
			foreach ($news as $new){
				$new->title = mb_substr($new->title,0,100);
				$new->image = ($new->image!='')?$new->image:$this->default_image;
				$new->short_description = mb_substr($new->short_description,0,200);
			}
		}
		return $news;
	}

	public function searchNews($text, $page=0){
		$page = $this->pageProperty($page);
		$news = DB::table($this->table . ' as news')
			->select($this->select)
			->join('mef_news_category as cate', 'cate.Id', '=', 'news.mef_news_category_id')
			->orderBy('create_date', 'desc')
			->orderBy('count_read', 'desc')
			->where('news.title', 'like', '%'.$text.'%')
			->limit($page['limit'])
			->offset($page['offset'])
			->get();
		if (!empty($news)){
			foreach ($news as $new){
				$new->title = mb_substr($new->title,0,110);
				$new->image = ($new->image!='')?$new->image:$this->default_image;
				$new->short_description = mb_substr($new->short_description,0,200);
			}
		}
		return $news;
	}

	public function advanceSearch($input){
		$page = $this->pageProperty($input['page']);
		$from = '1990-01-01 00:00:00';
		$to = date('Y-m-d H:s:i');
		$sql = DB::table($this->table . ' as news')
			->select($this->select)
			->join('mef_news_category as cate', 'cate.Id', '=', 'news.mef_news_category_id')
			->orderBy('create_date', 'desc')
			->orderBy('count_read', 'desc')
			->limit($page['limit'])
			->offset($page['offset']);
		if ($input['source']!='') {
			$sql = $sql->where('news.mef_news_category_id',$input['source']);
		}
		if ($input['fromdate']!=''){
			$from = $input['fromdate'].' 00:00:00';
		}
		if ($input['todate']!=''){
			$to = $input['todate'].' 24:59:59';
		}
		if (count($input['category'])!=0){
			$sql = $sql->whereIn('mef_news_tag_id',$input['category']);
		}
		$sql = $sql->whereBetween('create_date',[$from, $to]);
		$news = $sql->get();


		if (!empty($news)){
			foreach ($news as $new){
				$new->title = mb_substr($new->title,0,110);
				$new->image = ($new->image!='')?$new->image:$this->default_image;
				$new->short_description = mb_substr($new->short_description,0,200);
			}
		}
		return $news;
	}

	public function readNews($id){
		return DB::table($this->table)->where('Id',$id)->increment('count_read');
	}
}

?>