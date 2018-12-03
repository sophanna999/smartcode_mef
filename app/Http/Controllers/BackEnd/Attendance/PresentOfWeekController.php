<?php
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Input;
use DateTime;
use DB;
use Config;

use DatePeriod;
use DateInterval;
use App\libraries\Tool;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;
use App\Models\BackEnd\Attendance\AttendanceReportModel;
use App\Models\BackEnd\Attendance\PresentOfWeekModel;

class PresentOfWeekController extends BackendController{

	public function __construct(){
        parent::__construct();
        $this->present = new PresentOfWeekModel();
		$this->report = new AttendanceReportModel();
		$this->user = session('sessionUser');
		$this->data['converter'] = new Tool();
		if(!isset($this->user->mef_general_department_id))
			return array();

    }

	public function getIndex(Request $request){
		
       	$listDepartment = $this->report->getAllDepartmentBySecretariatId($this->user->mef_general_department_id,$this->user->mef_department_id);
       	
       	if(count($listDepartment)>=1){
       		$this->data['mef_department_id'] = $this->user->mef_department_id;
			$this->data['listOffice'] = json_encode($this->report->getOfficeByDepartmentId($this->user->mef_department_id));
		} else {
			$this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
		}
       	$this->data['listDepartment'] = json_encode($listDepartment);

    	$this->data['start_dt']= date("Y-m-d");
    	$this->data['end_dt']= date("Y-m-d");
    	if(sizeof($request)>0){
    		if($request->start_dt!=''){
    			$start_dt = $request->start_dt;
    		}
    	}
		return view($this->viewFolder.'.attendance.present-of-week.index')->with($this->data);
    }

	public function getSearch(Request $request){
		$listDepartment = $this->report->getAllDepartmentBySecretariatId($this->user->mef_general_department_id);
		
       	$this->data['listDepartment'] = json_encode($listDepartment);
       	
       	$this->data['listOffice'] = json_encode($this->report->getOfficeByDepartmentId($request->mef_department_id));
		
		/* init start to date*/
		if(isset($request->full_rang_day)){
			$interval = new DateInterval('P1D');
			$date_dt =  explode(' - ',$request->full_rang_day);
			if(sizeof($date_dt)==1){
				$date_dt = array(date("Y-m-d"),date("Y-m-d"));
			}
			$week_st = date('W', strtotime($date_dt[0]));
			$week_end = date('W', strtotime($date_dt[1]));
			if($week_st <>$week_end){
				return json_encode(array("code" => 0, "message" => trans('attendance.please_select').trans('attendance.attendance_date'), "data" => ''));
			}
			$this->data['start_dt'] = $date_dt[0];
			$this->data['end_dt'] = $date_dt[1];
		}
		$datas = $this->present->postSearch($request->all());
		$this->data['mef_department_id'] = $datas['departementId'];
		$this->data['mef_office_id'] = $datas['officeId'];
		$this->data['allOfficer'] = $datas['officers'];

		return view($this->viewFolder.'.attendance.present-of-week.index')->with($this->data);
	}

	public function getPrint(Request $request){
		$data = $this->present->postSearch($request->all());
		$this->data['allOfficer'] = $data['officers'];
		$this->data['year_dt'] = $data['year_dt'];
		$this->data['departement'] = $this->present->getDepartmentName($data['departementId']);
		$this->data['office'] = $this->present->getOfficeName($data['officeId']);
		return view($this->viewFolder.'.attendance.present-of-week.print')->with($this->data);
	}
	public function postCheckWeek(Request $request)
	{
		
		/* init start to date*/
		if(isset($request->full_rang_day)){
			$interval = new DateInterval('P1D');
			$date_dt =  explode(' - ',$request->full_rang_day);
			if(sizeof($date_dt)==1){
				$date_dt = array(date("Y-m-d"),date("Y-m-d"));
			}
			$week_st = date('W', strtotime($date_dt[0]));
			$week_end = date('W', strtotime($date_dt[1]));
			if($week_st <>$week_end){
				$data['start_dt']= date("Y-m-d");
				$data['end_dt']= date("Y-m-d");
				return json_encode(array("code" => 0, "message" => trans('attendance.please_select').trans('attendance.date'), "data" => $data));
			}
			
		}
	}

}
