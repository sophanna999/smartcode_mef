<?php 
namespace App\Http\Controllers\BackEnd\Document;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Document\DocumentTypeModel;

class DocumentTypeController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->docType = new DocumentTypeModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.document.document-type.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->docType->getDataGrid($request->all());
    }

    public function postNew(Request $request){

        return view($this->viewFolder.'.document.document-type.new')->with($this->data);
    }

    public function postEdit(Request $request){

        $this->data['row'] = $this->docType->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.document.document-type.new')->with($this->data);
    }
	public function postSave(Request $request){

        return $this->docType->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->docType->postDelete($listId);
    }

}
