<?php 
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use App\Models\BackEnd\Attendance\DoorTrackingModel;

use Excel;
use Config;
use App\libraries\Tool;
class DoorTrackingController extends BackendController {
    protected $from_date = '';
    protected $to_date = '';
    protected $is_late = '';
    protected $is_ot = '';
    protected $this_time = '';
    protected $tool;
	public function __construct(){
        parent::__construct();
		$this->constant = Config::get('constant');
        $this->tracking = new DoorTrackingModel();
        
    }
    public function getIndex(){
		$this->data['allOfficer'] = $this->tracking->getAllActiveOfficer();
		return view($this->viewFolder.'.attendance.door-tracking.index')->with($this->data);
    }
    public function postSearch(Request $request){
		$officer_id = $request->officer_id;
        $string_date = \DateTime::createFromFormat('d/m/Y', $request->fromDate)->format('Y-m-d');

        $resultComeBefore8AM = $this->tracking->postOfficerIsIn($string_date,$officer_id,$this->constant['comeBefore8AM_1'],$this->constant['comeBefore8AM_2']);
        $resultLateMorning8AM = $this->tracking->postOfficerIsIn($string_date,$officer_id,$this->constant['startMoringCondition8AM'],$this->constant['endMoringCondition830AM']);
        $resultLateMorning12PM = $this->tracking->postOfficerIsOut($string_date,$officer_id,$this->constant['startMoringCondition1130AM'],$this->constant['endMoringCondition1200AM']);
        $resultLateMorning1201AM = $this->tracking->postOfficerIsOut($string_date,$officer_id,$this->constant['startMoringCondition1201AM'],$this->constant['endMoringCondition1230AM']);
        $resultLateEvening0200PM = $this->tracking->postOfficerIsIn($string_date,$officer_id,$this->constant['startEveningCondition0200PM'],$this->constant['endEveningCondition0230PM']);
        $resultLateEvening0530AM = $this->tracking->postOfficerIsOut($string_date,$officer_id,$this->constant['startEveningCondition0530AM'],$this->constant['endEveningCondition0559AM']);
        $resultLateEvening0601AM = $this->tracking->postOfficerIsOut($string_date,$officer_id,$this->constant['startEveningCondition0601AM'],$this->constant['endEveningCondition2400AM']);
		
		return array(
			'comeBefore8AM'		=>$resultComeBefore8AM,
			'lateMorning8AM'	=>$resultLateMorning8AM, 
			'lateMorning12PM'	=>$resultLateMorning12PM, 
			'lateMorning1201AM'	=>$resultLateMorning1201AM,
			'lateEvening0200PM'	=>$resultLateEvening0200PM, 
			'lateEvening0530AM'	=>$resultLateEvening0530AM, 
			'lateEvening0601AM'	=>$resultLateEvening0601AM
		);
    }
    public function postDetail(Request $request){
        $officer_id = $request['officer_id'];
		$this->tool = new Tool();
        $date = \DateTime::createFromFormat('d/m/Y', $request['date'])->format('Y-m-d');
        $array_data = $this->tracking->getOfficerDetail($date,'',$officer_id,'','','');
        $this->data['data'] = $array_data;
        $this->data['date_string'] = $this->tool->khmerDate($date);
        $this->data['department_name'] = $this->tracking->getDepartmentById();
        $this->data['officer_name'] = $this->tracking->getOfficerById($officer_id);
        if ($array_data){
            return view($this->viewFolder.'.attendance.door-tracking.detail')->with($this->data);
        }
    }
    public function postReport(Request $request){
        $this->data['allOfficer'] = $this->tracking->getAllActiveOfficer();
        $this->data['timeCondition'] = $this->getTimeCondition();
        $this->data['defaultTime'] = $this->constant['startMoringCondition8AM'].','.$this->constant['endMoringCondition830AM'].','.'time_in';
        return view($this->viewFolder.'.attendance.door-tracking.report')->with($this->data);
    }
    private function getTimeCondition(){
        $arrList = array(
            array('text'=>trans('attendance.comeLateAfter8AM'),'value'=>$this->constant['startMoringCondition8AM'].','.$this->constant['endMoringCondition830AM'].','.'time_in'),
            array('text'=>trans('attendance.comeLateAfter2PM'),'value'=>$this->constant['startEveningCondition0200PM'].','.$this->constant['endEveningCondition0230PM'].','.'time_in'),
            array('text'=>trans('attendance.overtTime12PM'),'value'=>$this->constant['startMoringCondition1201AM'].','.$this->constant['endMoringCondition1230AM'].','.'time_out'),
            array('text'=>trans('attendance.overTime6PM'),'value'=>$this->constant['startEveningCondition0601AM'].','.$this->constant['endEveningCondition2400AM'].','.'time_out'),
        );
        return json_encode($arrList);
    }
    public function postSearchReport(Request $request){
        $officer_id = $request['officer_id'];
        $fromDate = '';
        $toDate = '';
        $time_1 = '';
        $time_2 = '';
        $type = '';
        if ($request['fromDate'] != ''){
            $fromDate = \DateTime::createFromFormat('d/m/Y', $request['fromDate'])->format('Y-m-d');
        }
        if ($request['toDate'] != ''){
            $toDate = \DateTime::createFromFormat('d/m/Y', $request['toDate'])->format('Y-m-d');
        }
        if ($request['time'] != ''){
            $time_string = explode(',',$request['time']);
            $time_1 = $time_string[0];
            $time_2 = $time_string[1];
            $type = $time_string[2];
        }
        $data = $this->tracking->getTotalAttendance($officer_id,$fromDate,$toDate,$time_1,$time_2,$type);
        return $data;
    }
    public function postDownloadReport($request){
        $officer_id = $request['report_officer_id'];
        $fromDate = '';
        $toDate = '';
        $type = '';
        $time_rule_1 = '';
        $time_rule_2 = '';
        if ($request['from_date_value'] != ''){
            $fromDate = \DateTime::createFromFormat('d/m/Y', $request['from_date_value'])->format('Y-m-d');
        }
        if ($request['to_date_value'] != ''){
            $toDate = \DateTime::createFromFormat('d/m/Y', $request['to_date_value'])->format('Y-m-d');
        }
        if ($request['time_condition'] != ''){
            $time_string = explode(',',$request['time_condition']);
            $time_rule_1 = $time_string[0];
            $time_rule_2 = $time_string[1];
            $type = $time_string[2];
        }
        $array_data = $this->tracking->getTotalAttendance($officer_id,$fromDate,$toDate,$time_rule_1,$time_rule_2,$type);
        return $array_data;
    }


    public function postGetExportData(Request $request){
        $array_data = $this->postDownloadReport($request->all());
        $time = $request->time_condition;
        $time_explode = explode(',',$time);
        $this->this_time = $time_explode[2];
        $this->from_date = $request->from_date_value;
        $this->to_date = $request->to_date_value;
        Excel::create('monthly_report', function($excel) use ($array_data) {
            $excel->sheet('excel', function($sheet) use ($array_data) {
                $data_cell = array();
                foreach ($array_data as $key => $row) {
					$total = $row->total >0 ? $row->total.' ដង':'';
                    $take_leave = $row->status == 1 ? $row->total >0 ? $row->total .'ថ្ងៃ':'':'';
                    if($row->status == 2){
                        $this->is_late = $this->this_time == 'time_in' ? $total:'';
                        $this->is_ot = $this->this_time == 'time_out' ? $total:'';
                    }
                    $data_cell[$key][trans('trans.autoNumber')] = intval($key + 1);
                    $data_cell[$key][trans('attendance.OfficerName')] = $row->officer_name;
                    $data_cell[$key][trans('attendance.permission_report')] = $take_leave;
                    $data_cell[$key][trans('attendance.absent')] = '';
                    $data_cell[$key][trans('attendance.mission')] = '';
                    $data_cell[$key][trans('attendance.late')] = $this->is_late;
                    $data_cell[$key][trans('attendance.over_time')] = $this->is_ot;
                }
                $sheet->fromArray($data_cell);
                $sheet->setFontFamily('Khmer MEF1');
                $countDataPlush1 = count($array_data) + 1;
                $sheet->setBorder('A1:G'.$countDataPlush1, 'thin');
                $sheet->row(1, function($row) {
                    $row->setBackground('#DFF0D8');
                });
                /* First row*/
                $sheet->prependRow(1, array(
                    trans('attendance.report_attendance').' '.$this->from_date.' ដល់ '.$this->to_date
                ));
                $sheet->mergeCells('A1:G1','center');
                $sheet->cell('A1:G1', function($cell) {
                    $cell->setFontFamily('Khmer MEF1');
                    $cell->setValignment('center');
                });
                $sheet->cell('A1:A'.($countDataPlush1 +1 ), function($cell) {
                    $cell->setAlignment('center');
                });
                $sheet->setHeight(1,30);

                /*Second row*/
                $department = $this->tracking->getDepartmentById();
                $sheet->prependRow(2, array(
                    trans('attendance.work_place').' '.$department->department_name
                ));
                $sheet->mergeCells('A2:G2','center');
                $sheet->cell('A2:G2', function($cell) {
                    $cell->setFontFamily('Khmer MEF1');
                    $cell->setValignment('center');
                });
                $sheet->cell('A2:A'.($countDataPlush1 +1 ), function($cell) {
                    $cell->setAlignment('center');
                });
                $sheet->setHeight(2,30);
				
            });
        })->export('xls');
    }
    public function postExport(Request $request){
        $data 	= $this->postDownloadReport($request->all());
        $countData = count($data);
        if($countData > 0){
            return array("code"=>1,"message"=>trans('schedule.please_wait'));
        }else{
            return array("code"=>0,"message"=>trans('schedule.no_data'));
        }
    }
}
