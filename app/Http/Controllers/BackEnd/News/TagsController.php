<?php 
namespace App\Http\Controllers\BackEnd\News;

use App\Http\Controllers\BackendController;
use App\Models\BackEnd\News\TagsModel;
use Illuminate\Http\Request;
use Config;

class TagsController extends BackendController {
	
	public function __construct(){
		parent::__construct();
		$this->constant = Config::get('constant');
		$this->tags = new tagsModel();
	}
    public function getIndex(){
        return view($this->viewFolder.'.news.tags.index')->with($this->data);
    }
	public function postIndex(Request $request){
        return $this->tags->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		return $this->loadView($request);
    }
    public function postEdit(Request $request){
        return $this->loadView($request);
    }
    private function loadView(Request $request){
        $id = intval($request->Id);
        $this->data['user_mood'] = json_encode($this->constant['user_mood']);
        $this->data['row'] = $this->tags->getDataByRowId($id);
		return view($this->viewFolder.'.news.tags.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->tags->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->tags->postDelete($listId);
    }

}
