<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\BackEnd\BackEndModel;

class AttendanceModel extends BackEndModel
{

    public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->Tool = new Tool();
		$this->user = session('sessionUser');
		$this->position_tran_id = array(6,7,9,10,14);
    }
	
    public function getDataByRowId($id){
        //return DB::table('v_take_leave_role_type')->where('Id', $id)->first();
        return  DB::select(DB::raw("call get_take_leave_role_type('".$id."');"));
    }
	
	public function getAllGeneralDepartment(){
        $arrList = DB::table('mef_secretariat')->orderBy('Name', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->Name,
                "value" => $row->Id
            );
        }
        return json_encode($arr);
	}
	public function checkTransferByPosition($user_id=null,$list=false)
	{
		if(isset($this->user) &&  isset($this->user->Id)){
			$user_id = $this->user->Id;
		}
		$is_transfer = 0;
		$is_approve = 0;
		$list_user_by_position = array(array('full_name_kh'=>'','Id' =>'','position'=>0));
		$info = $this->getApprovePersonalInfo($user_id);
		if($info){
			$by_posiion = DB::table('mef_position')->where('ID',$info->position_id)->whereNotNull('MEMBER_ID')->first();
			if($by_posiion){	
				// ករណីអ្នកមិនត្រូវការ return ឈ្មោះអ្នកនៅក្រោមការ គ្រប់គ្រងទេមិនចាំបាញ់ដំនើរការ query
				if($list==true){
					$list_user_by_position = DB::table('v_mef_officer')
					->select('full_name_kh','Id','position')
					->whereNull('approve')
					->where('active',1)
					->where('ministry_id',$info->ministry_id)
					->where('general_department_id',$info->general_department_id)
					->where('department_id',$info->department_id)
					->where('is_approve',2)						
					->whereIn('position_id',explode(',',$by_posiion->MEMBER_ID))
					->orderBy('position_order', 'asc')
					->get();
				}
				/* សម្រាប់អនុប្រធានផ្នែកមានសិទ្ធអនុញ្ញាតិច្បា់លុះត្រតែប្រធានផ្ទេសិទ្ធឲ្យ */
				$app_by_transfer = DB::table('mef_officer_right_transfer')->where('to_officer_id',$user_id)->count();
				if($app_by_transfer >0){
					$is_approve = 1;
				}
				
			}
			if(in_array($info->position_id,$this->position_tran_id)){
				$is_transfer =1;
				$is_approve = 1;
			}
		}
		
		return array(
			'is_approver'=>$is_approve
			,'is_transfer'=>$is_transfer
			,'mem_by_pos'=>$list_user_by_position
		);
		
	}
	public function getNumApproval($var = null)
	{
		$app_by_assign = DB::table('mef_take_leave_approver')->where('approver_id',$this->user->Id)->count();
		$app_by_transfer = DB::table('mef_officer_right_transfer')->where('to_officer_id',$this->user->Id)->count();
		return $is_approver = $app_by_assign + $app_by_transfer;
		
	}
	public function getAllDepartmentBySecretariatId($mef_secretariat_id){
        $arrList = DB::table('mef_department')->where('mef_secretariat_id',$mef_secretariat_id)->OrderBy('Name', 'ASC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
		return $arr;
        // return json_encode($arr);
    }
	public function getTakeLeavViewer($id=''){
		
		$list_type = DB::table('v_take_leave_role_type')
				->select('*')
				->whereNotNull('mef_viewer');
				// ->get();
		return $list_type;
	}
	
	public function getAttendanceType(){
		$list_type = DB::table('mef_take_leave_role_type')
			->select('*')
			->get();
		$arr = array(array("text"=>"", "value" => ""));
        foreach($list_type as $row){
            $arr[] = array(
                'text' 	=> $row->attendance_type,
                "value" => $row->Id
            );
        }
        return json_encode($arr);	
		// return $list_type;
	}
	public function getAttendanceViewer($first_min_id=''){
		
		$first_min_id= $this->getCurrentMinistryId();
		$list_type = DB::table('v_mef_officer')
			->select('full_name_kh','Id')
			->whereNull('approve')
			->where('active',1)
			->where('first_ministry',$first_min_id)
			->get();
		$arr = array(array("text"=>"", "value" => ""));
        foreach($list_type as $row){
            $arr[] = array(
                'text' 	=> $row->full_name_kh,
                "value" => $row->Id
            );
        }
        return json_encode($arr);	
		
	}
	
	public function getCurrentMinistryId(){
		$user = session('sessionUser');
		$list_type = DB::table('mef_secretariat')
			->select('mef_ministry_id','Id')
			->where('Id',$user->mef_general_department_id)
			->first();
		if(isset($list_type->mef_ministry_id))
			return $list_type->mef_ministry_id;
		
		return 0;
	}
	
	public function getOfficerName($data=''){
		
		foreach($data as $key => $val){
			$mef_viewers = explode(',', $val->mef_viewer);
			$mef_v = '';
			$mef_s = '';
			foreach($mef_viewers as $key1 => $val1){
				$list_data = DB::table('mef_personal_information')
					->select('FULL_NAME_KH')
					->where('ID',$val1)
					->first();
				if($mef_v =='' && $list_data!= null){
					$mef_v = $list_data->FULL_NAME_KH;
				}else{
					if(isset($list_data))
						$mef_v .= ','.$list_data->FULL_NAME_KH;
				}
				
				$list_status = DB::table('mef_take_leave_status')
					->select('status')
					->where('takeleave_id',$val->Id)
					->where('officer_id',$val1)
					->first();
				// $mef_s = $val->Id;
				if(isset($list_status->status) && $list_status->status==1){
					if($mef_s ==''){
						$mef_s = $list_data->FULL_NAME_KH;
					}else{
						$mef_s .= ','.$list_data->FULL_NAME_KH;
					}
				}
			}
			$data[$key]->mef_viewers = $mef_v;
			$data[$key]->approve_by = $mef_s;
			$data[$key]->day = $this->Tool->khmerNumber($val->duration);
			if(isset($val->not_status)){
				if($val->all_status==null){
					$val->all_status=0;
				}
				if($val->not_status==null){
					$val->not_status=0;
				}
				$data[$key]->notDay = $this->Tool->khmerNumber($val->not_status);
				$data[$key]->subDay = $this->Tool->khmerNumber($val->all_status);
				$all_status =0;
				if((18 - $val->all_status) >0){
					$all_status = 18 - $val->all_status;
				}
				$data[$key]->alltdays = $all_status;
				$data[$key]->tdays = $this->Tool->khmerNumber($all_status);
			}
			$data[$key]->started_dt = $this->Tool->dateformate($val->started_dt,'-');
			$data[$key]->end_dt = $this->Tool->dateformate($val->end_dt,'-');
			
			
		}
		return $data;
	}
	
	/* function validation not working day*/
	private function checkWorkingDay($take_date,$num_day,$section,$office_id,$off){
		$holiday = array();
		$check_holiday = DB::table('mef_holiday')
			->select(
				DB::raw('CONCAT(3) AS shift'),
				'date as dates',
				'title'
			)
			->where('status',1)->get();
			// ->whereIn('date',$arr_date)
		if($check_holiday){
			$holiday = array_merge($holiday,$check_holiday);
		}
		if(sizeOf($off)>0){
		$sp_holiday = DB::table('mef_specialday AS msp')
			->select(
				'shift',
				'date as dates',
				'reason as title'
			)
			// ->whereIn('date',$arr_date)
			->where('status',1)
			->leftJoin('mef_sub_specialday AS msub','msub.specialDayId','=','msp.Id')
			->orWhere('msub.departmentId',$off->department_id)
			->orWhere('msub.officeId',$off->office_id)
			->orWhere('msub.officerId',$off->mef_officer_id_approve)
			->get();
			$holiday = array_merge($holiday,$sp_holiday);
		}
		$last_date = $take_date;
		$d=$num_day;
		$array_dt = array();
		for($i=1;$i <=$d; $i++){				 
			if(date("N",strtotime($last_date))>5){
				$last_date = date("Y-m-d", strtotime($take_date . "+".$i." days"));
				$ck_holiday =false;
				goto end;
			}
			$ck_holiday =true;
			foreach($holiday as $val){
				
				if($section ==3 && $val->dates == $last_date){
					// dd($val->dates == $last_date);
					$ck_holiday =false;
				}else{
					if(($section ==$val->shift && $val->dates == $last_date)|| ($section <3 && $val->dates == $last_date)){
						$ck_holiday =false;
					}
				}
			}
			end:
			if($ck_holiday ==false){
				
				$d++;
			}
			if($ck_holiday==true){
				array_push($array_dt, $last_date);
			}
			$last_date = date("Y-m-d", strtotime($take_date . "+".$i." days"));
		}
		return $array_dt;
		
	}
	public function getCheckDate($request,$off=array()){
		$array_dt = array();
		
		if($request['officer_id'] && $request['take_date'] && $request['num_day'] && $request['section']){
			$array_dt = $this->checkWorkingDay($request['take_date'],$request['num_day'],$request['section'],$request['officer_id'],$off);
		}
		/* add comeback date on last of indexof array*/
		if(sizeOf($array_dt)>0){
			$last_dt = date("Y-m-d", strtotime($array_dt[sizeOf($array_dt)-1] . "+1 days"));
			$ls_date =  $this->checkWorkingDay($last_dt,1,$request['section'],$request['officer_id'],$off);
			array_push($array_dt,$ls_date[0]);
		}
		
		return $array_dt;          
	}
	
	public function listScanHistory($param)
	{
		return $list_db = DB::table('mef_user_attendance as ua')
			->select(DB::raw('DATE_FORMAT(morning_checkin, "%H:%i:%s %p") as morning_checkin')
					,DB::raw('DATE_FORMAT(morning_checkout, "%H:%i:%s %p") as morning_checkout')
					,DB::raw('DATE_FORMAT(evening_checkin, "%H:%i:%s %p") as evening_checkin')
					,DB::raw('DATE_FORMAT(evening_checkout, "%H:%i:%s %p") as evening_checkout')
					,DB::raw('DATE_FORMAT(date, "%Y-%m-%d") as date')
				)
			->where('mef_user_id',$param['mef_user_id'])
			->whereBetween('date',$param['date'])
			->get();
		// foreach($param as $key =>$val){
		// 	$list_db =$list_db->where($key,$val);
		// }
		// return $list_db->get();
	}
}
?>