<?php 
namespace App\Http\Controllers\BackEnd\Title;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Title\titleModel;

class TitleController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->title = new titleModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.title.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->title->getDataGrid($request->all());
    }
	/*public function postNew(){
        
        
        return view($this->viewFolder.'.position.new')->with($this->data);
    }*/

    public function postNew(Request $request){

        return view($this->viewFolder.'.title.new')->with($this->data);
    }

    public function postEdit(Request $request){
        $this->data['row'] = $this->title->getDataByRowId($request['Id']);

        return view($this->viewFolder.'.title.new')->with($this->data);
    }
	public function postSave(Request $request){
        //print_r($request->all());exit();
        return $this->title->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->title->postDelete($listId);
    }

}
