<?php 
namespace App\Http\Controllers\BackEnd\ClassRank;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\ClassRank\ClassRankModel;

class ClassRankController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->classRank = new ClassRankModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.class-rank.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->classRank->getDataGrid($request->all());
    }
	public function postNew(){
        return view($this->viewFolder.'.class-rank.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->classRank->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.class-rank.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->classRank->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->classRank->postDelete($listId);
    }

}
