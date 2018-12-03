<?php 
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Input;
use DB;
use Config;
use App\libraries\Tool;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;
use App\Models\BackEnd\Attendance\AttendanceReportModel;
use App\Models\BackEnd\Attendance\MonthlyReportModel;

class MonthlyReportController extends BackendController{
	
	public function __construct(){
        parent::__construct();
        $this->present = new MonthlyReportModel();
		$this->report = new AttendanceReportModel();
		$this->user = session('sessionUser');
		$this->data['converter'] = new Tool();
		if(!isset($this->user->mef_general_department_id))
			return array();
		
    }

	public function getIndex(Request $request){
       	$listDepartment = $this->report->getAllDepartmentBySecretariatId($this->user->mef_general_department_id);
       	
       	$this->data['listDepartment'] = json_encode($listDepartment);
    	$this->data['mef_department_id'] = $listDepartment[0]['value'];
    	// dd($this->data['mef_department_id']);
    	$this->data['start_dt']= date("Y-m-d");
    	$this->data['end_dt']= date("Y-m-d");
    	if(sizeof($request)>0){
    		if($request->start_dt!=''){
    			$start_dt = $request->start_dt;
    		}
    	}
		return view($this->viewFolder.'.attendance.monthly-report.index')->with($this->data);
    }
	
	public function getSearch(Request $request){
		$listDepartment = $this->report->getAllDepartmentBySecretariatId($this->user->mef_general_department_id);
       	
       	$this->data['listDepartment'] = json_encode($listDepartment);
       	$this->data['listOffice'] = json_encode($this->report->getOfficeByDepartmentId($request->mef_department_id));
		
		$this->data['listData'] = $this->present->postSearch($request->all());
		$datas = $this->present->postSearch($request->all());
		// dd($request->start_dt);
		$this->data['start_dt'] = $request->start_dt;
    	$this->data['end_dt'] = $request->end_dt;
		$this->data['mef_department_id'] = $request->mef_department_id;
		return view($this->viewFolder.'.attendance.monthly-report.index')->with($this->data);
	}
	
	public function getPrint(Request $request){
		$allData = $this->present->postSearch($request->all());
		// dd($allData);
		$this->data['allData'] = $this->present->postSearch($request->all());
		$this->data['daptName'] = isset($allData[0]->deptName) ? $allData[0]->deptName:'';
		$this->data['month'] = isset($allData[0]->monthly) ? $allData[0]->monthly:'';
		$this->data['year'] = isset($allData[0]->year) ? $allData[0]->year:0;
		return view($this->viewFolder.'.attendance.monthly-report.print')->with($this->data);
	}
	
}