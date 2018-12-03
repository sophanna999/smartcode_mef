<?php 

namespace App\Http\Controllers\BackEnd\Document;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\BackEnd\Document\Doc;
class DocumentController extends BackendController {

    public function __construct(){
        parent::__construct();
        $this->userSession = session('sessionUser');
    }

    public function getIndex(){
        return view($this->viewFolder.'.document.document.index')->with($this->data);
    }
	public function setting(){

		$Doc = Doc::find(1);
		return $Doc;
		
	}
	
	public function postIndex(Request $request){
        return $this->doc->getDataGrid($request->all());
    }

    public function postNew(Request $request){
        $this->data['list_Type'] = json_encode($this->doc->getType());
        $this->data['list_Unit'] = json_encode($this->doc->getUnit());
        $this->data['list_Officer'] = json_encode($this->doc->getOfficer());
        $this->data['list_DocumentType'] = json_encode($this->doc->getDocumentType());
        $this->data['list_Office'] = json_encode($this->doc->getOffice());
//        filter
        $this->data['list_MinistryFilter'] = json_encode($this->doc->getMinistry());
        $this->data['list_SecretariatFilter'] = json_encode(array(array("text"=>"", "value" => "")));
        $this->data['list_DepartmentFilter'] = json_encode(array(array("text"=>"", "value" => "")));
        $this->data['list_OfficeFilter'] = json_encode(array(array("text"=>"", "value" => "")));

       return view($this->viewFolder.'.document.document.new')->with($this->data);
    }

    public function postDocumentsProcessing(Request $request)
    {
        $this->data['list_Type'] = json_encode($this->doc->getType());
        $this->data['list_Unit'] = json_encode($this->doc->getUnit());
        $this->data['list_Officer'] = json_encode($this->doc->getOfficer());
        $this->data['list_DocumentType'] = json_encode($this->doc->getDocumentType());
        $this->data['list_Office'] = json_encode($this->doc->getOffice());
//        filter
        $this->data['list_MinistryFilter'] = json_encode($this->doc->getMinistry());
        $this->data['list_SecretariatFilter'] = json_encode(array(array("text"=>"", "value" => "")));
        $this->data['list_DepartmentFilter'] = json_encode(array(array("text"=>"", "value" => "")));
        $this->data['list_OfficeFilter'] = json_encode(array(array("text"=>"", "value" => "")));

        return view($this->viewFolder.'.document.document.document-processing')->with($this->data);

    }

    public function postFormUnitNew(Request $request){
        return view($this->viewFolder.'.document.document-unit.new')->with($this->data);
    }

    public function postFormNewDocType(Request $request){
        return view($this->viewFolder.'.document.document-type.new')->with($this->data);
    }

    public function postEdit(Request $request){

        $this->data['row'] = $this->doc->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.document.document.new')->with($this->data);
    }
	public function postSave(Request $request){
//       dd($request->all());
        return $this->doc->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->doc->postDelete($listId);
    }

    public function postGetSecretariatFilter(Request $request){
        $ministry_id = intval($request->ministry_id);
        $result = $this->doc->getSecretariatFilter($ministry_id);
        return $result;
    }

    public function postGetDepartmentFilter(Request $request){
        $secretariat_id = intval($request->secretariat_id);
        $result = $this->doc->getDepartmentFilter($secretariat_id);
        return $result;
    }
    public function postGetOfficeFilter(Request $request){
        $department_id = intval($request->department_id);
        $result = $this->doc->getOfficeFilter($department_id);
        return $result;
    }

    public function postDeleteProcessingDoc(Request $request){
        $Id = isset($request['sId']) ? $request['sId']:'';
        return $this->student->deleteProcessingDoc($Id);
    }


}
