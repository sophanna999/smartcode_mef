<?php 
namespace App\Http\Controllers\FrontEnd\News;
use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Models\FrontEnd\NewsModel;
use Illuminate\Support\Facades\Input;
use Session;

class NewsController extends FrontendController {
    public function __construct(){
        parent::__construct();

		$this->news = new NewsModel();

		if ($this->userGuestSession != null){
			$this->data['categories'] = $this->news->getAllCategory();
			$this->data['tags'] = $this->news->getAllTag();
            $this->officer_id = $this->userGuestSession->Id;
        }
    }

    public function getIndex(){
        return view($this->viewFolder.'.news.index')->with($this->data);
    }
    public function getCategory(){
	    return $this->news->getAllCategory();
    }

	public function getTag(){
		return $this->news->getAllTag();
	}
    public function postData(Request $request){
	    $news = $this->news->getLatestNews($request->page);
        return $news;
    }
    public function getDetail(){
        return view($this->viewFolder.'.news.detail')->with($this->data);
    }
    public function postDetail(Request $request){
    	$id = $request->id;
	    $output = [];
	    if ($request->count) $this->news->readNews($id);
	    $topNews = $this->news->getTopNews($id);
	    $news = $this->news->getNewsById($id);

	    $output = [
	    	'news' => $news,
		    'topNews' =>$topNews
	    ];
        return $output;
    }

	public function getListview(){
		
		return view($this->viewFolder.'.news.list-news')->with($this->data);
	}

	public function postSearch(Request $request){
		$output = [];
		$text = $request->text;
		$page = $request->page;
		$news = $this->news->searchNews($text, $page);
		$output = [
			'news'=>$news,
			'page_title'=>"លទ្ធផលនៃការស្វែងរក"
		];
		return $output;
	}
	public function postCategory(Request $request){
		$output = [];
		$id = $request->id;
		$page = $request->page;
		$news = $this->news->getListNewsByCategory($id, $page);
		$category_name = $this->news->getCategoryNameById($id);
		
		$output = [
			'news'=>$news,
			'category_name'=>$category_name,
			'active'=>$id
		];
		
		return $output;
	}

	public function postSearchadvance(Request $request){
		$output = [];
		$news = $this->news->advanceSearch($request->all());
		$output = [
			'news'=>$news,
			'page_title'=>"លទ្ធផលនៃការស្វែងរក"
		];
		return $output;
	}
}
