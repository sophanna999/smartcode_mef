<?php 
namespace App\Http\Controllers\BackEnd\Document;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Document\DocumentUnitModel;

class DocumentUnitController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->docUnit = new DocumentUnitModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.document.document-unit.index')->with($this->data);
    }
	
	public function postIndex(Request $request){

        return $this->docUnit->getDataGrid($request->all());
    }

    public function postNew(Request $request){
        return view($this->viewFolder.'.document.document-unit.new')->with($this->data);
    }

    public function postEdit(Request $request){

        $this->data['row'] = $this->docUnit->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.document.document-unit.new')->with($this->data);
    }
	public function postSave(Request $request){

        return $this->docUnit->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->docUnit->postDelete($listId);
    }


}
