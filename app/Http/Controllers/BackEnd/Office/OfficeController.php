<?php 
namespace App\Http\Controllers\BackEnd\Office;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Office\OfficeModel;

class OfficeController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->office = new OfficeModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.office.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->office->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		return $this->loadView($request);
    }
	public function postEdit(Request $request){
        return $this->loadView($request);
    }
	private function loadView(Request $request){
		$this->data['row'] = $this->office->getDataByRowId($request['Id']);
		$listMinistry = $this->office->getAllMinistry();
		$this->data['listMinistry'] = json_encode($listMinistry);
		
		$arr_1 = array(array("text"=>"", "value" => ""));
		$arr_2 = array(array("text"=>"", "value" => ""));
		
		if($request['Id'] != 0){
			$data_1 = $this->office->getAllSecretariatByMinistry($this->data['row']->mef_ministry_id);	
			$data_2 = $this->office->getAllDepartmentBySecretariatId($this->data['row']->mef_secretariat_id);	
			$this->data['listSecretariat'] = json_encode($data_1);
			$this->data['listDepartment'] = json_encode($data_2);
		}else{
			$this->data['listSecretariat'] = json_encode($arr_1);
			$this->data['listDepartment'] = json_encode($arr_2);
		}
		
        return view($this->viewFolder.'.office.new')->with($this->data);
	}
	public function postGetSecretaryByMinistryId(Request $request){
		$ministryId = intval($request->ministryId);
		$this->data['listSecretariat'] = $this->office->getAllSecretariatByMinistry($ministryId);
		return $this->data['listSecretariat'];
	}
	public function postGetDepartmentBySecretariatId(Request $request){
		$secretariatId = intval($request->secretariatId);
		$this->data['listDepartment'] = $this->office->getAllDepartmentBySecretariatId($secretariatId);
		return $this->data['listDepartment'];
	}
	public function postSave(Request $request){
        return $this->office->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->office->postDelete($listId);
    }

}
