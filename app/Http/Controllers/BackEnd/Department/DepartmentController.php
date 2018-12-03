<?php 
namespace App\Http\Controllers\BackEnd\Department;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Department\DepartmentModel;

class DepartmentController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->department = new DepartmentModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.department.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->department->getDataGrid($request->all());
    }
	public function postNew(Request $request){
        return $this->loadView($request);		
    }
	public function postEdit(Request $request){
        return $this->loadView($request);
    }
	private function loadView($request){
		$this->data['row'] = $this->department->getDataByRowId($request['Id']);
		$listMinistry = $this->department->getAllMinistry();
		$this->data['listMinistry'] = json_encode($listMinistry);
		
		$arr = array(array("text"=>"", "value" => ""));
		if($request['Id'] != 0){
			$data = $this->department->getAllSecretariatByMinistry($this->data['row']->mef_ministry_id);
			$this->data['listSecretariat'] = json_encode($data);
		}else{
			$this->data['listSecretariat'] = json_encode($arr);
		}
		
        return view($this->viewFolder.'.department.new')->with($this->data);
	}
	public function postGetSecretaryByMinistryId(Request $request){
		$ministryId = intval($request->ministryId);
		$this->data['listSecretariat'] = $this->department->getAllSecretariatByMinistry($ministryId);
		return $this->data['listSecretariat'];
	}
	public function postSave(Request $request){
        return $this->department->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->department->postDelete($listId);
    }
	
	

}
