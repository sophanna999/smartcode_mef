<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Session;

class MonthlyReportModel{
	
	public function __construct(){
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->Tool  = new Tool();
    }
	
	public function postSearch($data){
		$start_date = date('Y-m-d H:i:s', strtotime($data['start_dt']));

		$datas = DB::table('v_officer_attendance')->where('deptId',$data['mef_department_id'])
												 ->whereBetween('date', array($start_date, $data['end_dt']))
												 ->groupBy('officer_id')
												 ->orderBy('orderNumber','ASC')
												 ->get();

		//  $data['start_dt'];
		// $data['end_dt'];
		
		return $datas;
	}
	
	
}