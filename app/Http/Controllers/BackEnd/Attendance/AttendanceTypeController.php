<?php 
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;

use App\Models\BackEnd\Attendance\AttendanceTypeModel;
use App\Models\BackEnd\Attendance\AttendanceReportModel;
class AttendanceTypeController extends BackendController
{
	public function __construct(){
        parent::__construct();
        $this->attendance = new AttendanceTypeModel();
		
		$this->user = session('sessionUser');
		if(!isset($this->user->mef_general_department_id))
			return array();
		
    }
	
	public function getIndex(){
		return view($this->viewFolder.'.attendance.type.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->attendance->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		$listDepartment = $this->attendance->getAllDepartmentBySecretariatsId($this->user->mef_general_department_id,$this->user->mef_department_id);
		if(count($listDepartment) == 1){
			$this->data['mef_department_id'] = $listDepartment[0]->value;
			$this->data['listOffice'] = json_encode($this->attendance->getOfficeByDepartmentsId($listDepartment[0]->value,1));
		} else {
			$this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
		}
		$this->data['pos'] = json_encode($this->attendance->getPositions());
       	$this->data['listDepartment'] = json_encode($listDepartment);
		$this->data['attendanceViewer']= $this->attendance->getAttendanceViewer($this->user->mef_general_department_id);
		return view($this->viewFolder.'.attendance.type.new')->with($this->data);
    }
	
	public function postEdit(Request $request){
		$this->data['row'] = $this->attendance->getDataByRowId($request['Id']);
		if($this->data['row']){
			$this->data['pos_ttype'] = json_encode($this->attendance->getPositionByTakeLeaveType($request['Id']));
		}
		$listDepartment = $this->attendance->getAllDepartmentBySecretariatsId($this->user->mef_general_department_id,$this->user->mef_department_id);
		if(count($listDepartment) == 1){
			$this->data['mef_department_id'] = $listDepartment[0]->value;
			$this->data['listOffice'] = json_encode($this->attendance->getOfficeByDepartmentsId($listDepartment[0]->value,1));
		} else {
			$this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
		}
		$this->data['pos'] = json_encode($this->attendance->getPositions());
		$this->data['listDepartment'] = json_encode($listDepartment);
		return view($this->viewFolder.'.attendance.type.new')->with($this->data);
    }
	
	public function postGetDepartmentBySecretariatId(Request $request){
		$secretariatId = intval($request->secretariatId);
		$records = $this->attendance->getAllDepartmentBySecretariatsId($secretariatId);
		return ($records);
		
	}
	
	public function postSave(Request $request){ //dd($request->all());
        return $this->attendance->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->attendance->postDelete($listId);
    }
	public function getDelete($id){
        return $this->attendance->postDelete(1);
    }
}