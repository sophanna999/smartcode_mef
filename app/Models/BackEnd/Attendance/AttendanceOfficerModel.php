<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AttendanceOfficerModel
{
	public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
		$this->member = explode(',',$this->userSession->mef_member_id);
		array_push($this->member,strval($this->userSession->id));
    }
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "date";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = $this->getAttendanceOfficerReferen();
		$total = $listDb->count();
        $a ='';
        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                $a=$arrFilterValue;
                switch($arrFilterName){
                    case 'officer_name':
                        $listDb = $listDb->where('pi.FULL_NAME_KH','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'section':
                        if($arrFilterValue==trans('attendance.morning')){
                            $section=1;
                        }else if ($arrFilterValue==trans('attendance.full_day')){
                            
                            $section=3;
                        }else{
                            $section=2;
                        }
                        $listDb = $listDb->where('section',$section);
                        break;
                    case 'date':
                        $listDb = $listDb->whereRaw('DATE_FORMAT(`uar`.`date`,"%Y-%m-%d")=DATE_FORMAT("'.$arrFilterValue.'","%Y-%m-%d")');
                        break;
                    case 'office_name':
                        $listDb = $listDb->where('office_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = $listDb->count();
        }   
		$listDb = $listDb
                ->orderBy($sort, $order)
				->take($limit)
				->skip($offset)
				->get();
        // return $listDb->toSql();
        return json_encode(array('total'=>$total,'items'=>$listDb,'a'=>$a));
    }
    public function getDataByRowId($id){
        return $this->getAttendanceOfficerReferen()->where('tls.Id', $id)->first();      
    }
    public function getAttendanceOfficerReferen()
    {
    	return $db_list= DB::table('mef_take_leave as tls')
					->select(DB::raw('tls.id as Id
						,tls.section as sect						
						,tls.take_leave_role_type_id 
						,tls.day as num_day
						,tls.end_dt 
						,tls.status 
						,tls.start_dt 
						,tls.start_dt as date
						,tls.reason as detail
						,pi.FULL_NAME_KH as officer_name
						,ssi.CURRENT_OFFICE
						,(CASE WHEN tls.section = 1 THEN "ពេលព្រឹក" WHEN tls.section = 3 THEN "ពេញមួយថ្ងៃ"ELSE "ពេលល្ងាច" END) as section 
						,tls.officer_id,
						(SELECT Name FROM mef_office WHERE id=ssi.CURRENT_OFFICE) as office_name
						'
						))
					->leftJoin('mef_service_status_information as ssi','ssi.MEF_OFFICER_ID','=','tls.officer_id')   
					->leftJoin('mef_personal_information as pi','pi.MEF_OFFICER_ID','=','tls.officer_id')
					->whereIn('tls.request_by',$this->member);
    }
    public function getFile($take_leave_id='')
    {
        return DB::table('mef_take_leave_file')->where('take_leave_id',$take_leave_id)->get();
    }
    public function getTakeLeavRoleType(){
		$list_type = DB::table('mef_take_leave_role_type as v_take')
			->select(
				'v_take.Id as value',
				'v_take.attendance_type as text'
			)
			->whereIn('v_take.created_by',$this->member)
			->get();
		return $list_type;
	}
	
	public function validationAttendance($data){
		$count = array();
		$year  = date("Y");
		$userId = $data['userId'];
		$userName = $data['userName'];
		$takeLeaveId = $data['take_leave_id'];
		$res = DB::table('mef_service_status_information as info')
			   ->leftJoin('mef_take_leave_status as status','status.officer_id','=','info.MEF_OFFICER_ID')
			   ->leftJoin('mef_position as position','position.ID','=','info.CURRENT_POSITION')
			   ->select('info.CURRENT_POSITION as position','info.LEVEL_STATUS as level_status','status.day as day')
			   ->where('info.MEF_OFFICER_ID', $userId)
			   ->where('status.takeleave_id', $takeLeaveId)
			   ->whereYear('take_date', '=', $year)
			   ->get();
		foreach($res as $key => $value){
			$count[] = $value->day;
		}
		$num = array_sum($count);
		if(!empty($res)){
			if($res[0]->position == 20){
				if($num == 12 || $num == 15 || $num == 18){
					return array('msg' => $userName.' កន្លងមកបានសុំឈប់សំរាករយ:ពេលខ្លីបានចំនួន '.$num.' ថ្ងៃរួចមកហើយ');
				} else {
					return array('msg' => '');
				}
			} else {
				if($res[0]->level_status == 1){
					if($num == 15 || $num == 30){
						return array('msg' => $userName.' កន្លងមកបានសុំឈប់សំរាករយ:ពេលខ្លីបានចំនួន '.$num.' ថ្ងៃរួចមកហើយ');
					} else {
						return array('msg' => '');
					}
				} else {
					if($num == 12 || $num == 15){
						return array('msg' => $userName.' កន្លងមកបានសុំឈប់សំរាករយ:ពេលខ្លីបានចំនួន '.$num.' ថ្ងៃរួចមកហើយ');
					} else {
						return array('msg' => '');
					}
				}
			}
		}
		return array('msg' => '');
    }
	
    public function getAttendanceViewer($mef_general_department_id=''){
        $list_type = DB::table('v_mef_officer')
            ->select('full_name_kh as text','Id as value','position')
            ->where('general_department_id',$mef_general_department_id)
            // ->where('department_id',$this->userSession->mef_department_id)
			// ->where('is_approve',2)
			->where('active',1)
			->whereNull('approve')
            ->orderBy('position_order', 'desc')
            ->get();
        return array_merge(array((object) array("text"=>"", "value" => "","position"=>"")),$list_type);
    }
	public function getTakeLeavRole($request){
		
		// $rol = DB::table('mef_take_leave_user_role as urole')->where('urole.officer_id',$request['officer_Id'])->first();
		// if($rol){
			// $db= DB::table('mef_take_leave_type as ttype')
				// ->select('ttype.Id as value','ttype.attendance_title as text')
				// ->whereIn('ttype.Id',explode(',',$rol->take_leave_type_id))->get();
				// return array_merge(array((object) array("text"=>"", "value" => "","position"=>"")),$db);
		// }
		return array((object) array("text"=>"", "value" => "","position"=>""));
	}
	public function getTakeLeavRoleByPosition($position_id){
		$listDb = DB::table('mef_take_leave_role_type_by_position AS tk_pos')
			->select(
				'tk_type.attendance_type AS text'
				,'tk_type.Id AS value'
			)
			->leftJoin('mef_take_leave_role_type AS tk_type','tk_type.Id','=','tk_pos.mef_take_leave_type_id')
			->where('tk_pos.position_id',$position_id)
			->get();
		return array_merge(array((object) array("text"=>"", "value" => "")),$listDb);
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
	public function doDeleteFile($data)
	{
	  	DB::table('mef_take_leave_file')->where('id', $data['Id'])
	  		->update(array('status'=>0));
	  	return array("code"=>1,"message"=>trans('schedule.please_wait'));
	}
}
