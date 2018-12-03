<?php 
namespace App\Http\Controllers\BackEnd\User;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\ResourceModel;
use App\Models\BackEnd\Position\titleModel;

class FrontEndResourceController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->resource = new ResourceModel();
		$this->position = new titleModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.users.front-end-resource.index')->with($this->data);
    }
	
	public function postIndex(){
        return $this->resource->getFrontEndDataGrid();
    }
	
	private function loadView(Request $request){
        $this->data['Id'] = $request['Id'];
        $dataResponse = $this->resource->postNewFrontEnd($request['Id']);
        $this->data['authentication'] = $dataResponse['authentication'];
        $this->data['listAuthentication'] = $dataResponse['listAuthentication'];
        return view($this->viewFolder.'.users.front-end-resource.new')->with($this->data);
    }
	
	public function postNew(Request $request){
		return $this->loadView($request);
    }
	
	public function postEdit(Request $request){
        return $this->loadView($request);
    }
	
	public function postPrivilege(Request $request){
		$id = intval($request['Id']);
		$this->data['row'] = $this->resource->getDataByRowId($id);
		return view($this->viewFolder.'.users.front-end-resource.privilege')->with($this->data);	
	}
	
	public function postPosition(Request $request){
		return $this->data['positionValue'] = $this->position->getPositionViewer();
	}

	public function postSavePrivilege(Request $request){
        return $this->resource->postSavePrivilege($request->all());
    }
	
	public function postSave(Request $request){
        return $this->resource->postSave($request->all());
    }
	
	public function postPrivilegeById(Request $request){
		$id = intval($request['Id']);
		return $this->resource->getPrivilegeById($id);
	}
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->resource->postDelete($listId);
    }
}
