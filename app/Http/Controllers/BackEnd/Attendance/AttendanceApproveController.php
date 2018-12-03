<?php
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;

use App\Models\BackEnd\Attendance\AttendanceApproveModel;
use App\Models\BackEnd\Attendance\AttendanceReportModel;

class AttendanceApproveController extends BackendController
{
	public function __construct(){
        parent::__construct();
        $this->attendance = new AttendanceApproveModel();
		$this->report = new AttendanceReportModel();
		$this->user = session('sessionUser');
		if(!isset($this->user->mef_general_department_id))
			return array();

    }

	public function getIndex(){
		return view($this->viewFolder.'.attendance.approve.index')->with($this->data);
    }

	public function postIndex(Request $request){
        return $this->attendance->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		$this->data['pos'] = json_encode($this->attendance->getTakeLeavRoleType());
		
		$this->data['approved'] = $this->attendance->getOfficeApprove();
		$this->data['response'] = $this->attendance->getResponsibleOrder();
		// dd(json_decode($this->data['approved']));
		return view($this->viewFolder.'.attendance.approve.new')->with($this->data);
    }

	
	public function postEdit(Request $request){
		$this->data['row'] = $this->attendance->getDataByRowId($request['Id']);
		$this->data['response'] = $this->attendance->getResponsibleOrder();
		$this->data['pos'] = json_encode($this->attendance->getTakeLeavRoleType());
		$this->data['approved'] = $this->attendance->getOfficeApprove();
		$this->data['take_approved'] = $this->attendance->getTakeLeaveApprover($request['Id']);
		$this->data['take_leave_role'] = json_encode($this->attendance->getTakeLeaveRole($request['Id']));
		// dd($this->data['take_leave_role']);
		return view($this->viewFolder.'.attendance.approve.new')->with($this->data);
    }

	public function postGetDepartmentBySecretariatId(Request $request){
		$secretariatId = intval($request->secretariatId);
		$records = $this->attendance->getAllDepartmentBySecretariatId($secretariatId);
		return ($records);

	}
	public function postGetOfficeByDepartmentId(Request $request){
        $departmentId = intval($request->departmentId);
        $listOffice = $this->attendance->getOfficeByDepartmentsId($departmentId);
        return ($listOffice);
    }
	public function postSave(Request $request){
		//dd($request->all());
        return $this->attendance->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->attendance->postDelete($listId);
    }
	
}
