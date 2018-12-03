<?php 
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;
use App\Models\BackEnd\Attendance\AttendanceUserModel;
class AttendanceUserController extends BackendController
{
	public function __construct(){
        parent::__construct();
        $this->attendance = new AttendanceUserModel();
		$this->user = session('sessionUser');
		if(!isset($this->user->mef_general_department_id))
			return array();	
		
		
    }
	
	public function getIndex(){
		return view($this->viewFolder.'.attendance.user.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->attendance->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		// dd($this->user);
		$this->data['attendanceViewer']= $this->attendance->getAttendanceViewer($this->user->mef_general_department_id);
		$this->data['takeLeave']= $this->attendance->getTakeLeavType($this->user->mef_general_department_id);
		// dd($this->data['attendanceViewer']);
		return view($this->viewFolder.'.attendance.user.new')->with($this->data);
    }
	
	public function postEdit(Request $request){	
		$this->data['row'] = $this->attendance->getDataByRowId($request['Id']);
		$this->data['attendanceViewer']= $this->attendance->getAttendanceViewer($this->user->mef_general_department_id);
		$this->data['takeLeave']= $this->attendance->getTakeLeavType($this->user->mef_general_department_id);
		// dd($this->data['takeLeave']);
		return view($this->viewFolder.'.attendance.user.new')->with($this->data);
    }
	
	public function postGetDepartmentBySecretariatId(Request $request){
		$secretariatId = intval($request->secretariatId);
		$records = $this->attendance->getAllDepartmentBySecretariatId($secretariatId);
		return ($records);
		
	}
	public function postSave(Request $request){
		// dd($request->all());
		// return json_encode($request->all());
		return $this->attendance->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->attendance->postDelete($listId);
    }
	public function getDelete($id){
        // $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->attendance->postDelete(1);
    }
}