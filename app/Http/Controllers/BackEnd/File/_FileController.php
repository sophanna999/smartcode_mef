<?php 
namespace App\Http\Controllers\BackEnd\File;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\File\FileModel;

class FileController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->file = new FileModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.file.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->file->getDataGrid($request->all());
    }
	public function postNew(){
        return view($this->viewFolder.'.file.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->file->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.file.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->file->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->file->postDelete($listId);
    }

}
