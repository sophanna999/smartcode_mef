<?php 
namespace App\Http\Controllers\BackEnd\GeneralDepartment;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\GeneralDepartment\GeneralDepartmentModel;

class GeneralDepartmentController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->generalDepartment = new GeneralDepartmentModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.general-department.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->generalDepartment->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		$this->data['listMinistry'] = $this->generalDepartment->getAllMinistry();
        return view($this->viewFolder.'.general-department.new')->with($this->data);
    }
	public function postEdit(Request $request){
		$this->data['listMinistry'] = $this->generalDepartment->getAllMinistry();
        $this->data['row'] = $this->generalDepartment->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.general-department.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->generalDepartment->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->generalDepartment->postDelete($listId);
    }

}
