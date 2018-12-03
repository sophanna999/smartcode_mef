<?php 
namespace App\Http\Controllers\BackEnd\User;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\ResourceModel;

class ResourceController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->resource = new ResourceModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.users.resource.index')->with($this->data);
    }
	public function postIndex(){
        return $this->resource->getDataGrid();
    }
	public function postNew(Request $request){
		return $this->loadView($request);
    }
    public function postEdit(Request $request){
        return $this->loadView($request);
    }
    private function loadView(Request $request){
        $this->data['Id'] = $request['Id'];
        $dataResponse = $this->resource->postNew($request['Id']);
        $this->data['authentication'] = $dataResponse['authentication'];
        $this->data['listAuthentication'] = $dataResponse['listAuthentication'];
        return view($this->viewFolder.'.users.resource.new')->with($this->data);
    }
	public function postPrivilege(Request $request){
		$id = intval($request['Id']);
		$this->data['row'] = $this->resource->getDataByRowId($id);
		return view($this->viewFolder.'.users.resource.privilege')->with($this->data);	
	}
	public function postSavePrevilege(Request $request){
		dd($request->all());
	}
	public function postSave(Request $request){
        return $this->resource->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->resource->postDelete($listId);
    }
}
