<?php namespace App\Http\Controllers\BackEnd\User;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\RoleModel;

class RoleController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->role = new RoleModel();
    }

    public function getIndex(){
        $this->data['inputUrl'] = $this->role->getRoleName();
        return view($this->viewFolder.'.users.role.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->role->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		return $this->loadView($request);
    }
    public function postEdit(Request $request){
        return $this->loadView($request);
    }
    private function loadView(Request $request){
        $this->data['Id'] = intval($request['Id']);
        $dataModels = $this->role->postNew($this->data['Id']);
        $this->data['row'] = $dataModels['role'];
        $listJoinGroupCheck =  explode(',',empty($dataModels['role']->parent_id) ? "''" : $dataModels['role']->parent_id);
        //print_r($listJoinGroupCheck); exit();
        $this->data['allAuthentication'] = json_encode($dataModels['allAuthentication']);
        $this->data['selectedAuthentication'] = $dataModels['selectedAuthentication'];
        $this->data['listJoinGroup'] = json_encode($this->role->getListJoinGroup());
		$this->data['listJoinGroupCheck'] = json_encode($this->role->getListJoinGroupCheck($listJoinGroupCheck));
		return view($this->viewFolder.'.users.role.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->role->postSave($request->all());
    }
	public function postDelete(Request $request)
    {
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->role->postDelete(intval($listId));
    }

}
