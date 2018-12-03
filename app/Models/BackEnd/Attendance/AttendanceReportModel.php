<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use Excel;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\BackEnd\BackEndModel;

class AttendanceReportModel extends BackEndModel
{

    public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
		$this->userSession = session('sessionUser');
		
    }
	public function postSave($data){
        if($data){
            unset($data['_token']);
        }
        if($data['Id']==0){
            /* Save data */
			$result = DB::table('mef_take_leave_role_type')->where('attendance_type', $data['attendance_type'])->count();
			if($result >0){
				return json_encode(array("code" => 0, "message" => $this->messages['take-leave-type']."មិនអនុញ្ញាតិឲ្យដូចគ្នា", "data" => ""));
			}
			
			$data['mef_officer_id']= $this->userSession->id;
			DB::table('mef_take_leave_role_type')->insert($data);
            /* End Save data */
        }else{
            DB::table('mef_take_leave_role_type')
				->where('Id', $data['Id'])
				->update([
					'description'		=>$data['description'],
					'officer_id'		=>$data['officer_id'],
					'attendance_type'		=>$data['attendance_type']
				]);
        }
       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
	
    public function postDelete($Id){
        $is_delete = DB::table('mef_take_leave_role_type')->whereIn('Id', $Id)->delete();
		if($is_delete)
			return array("code" => 1,"message" => trans('trans.success'));
		// return array("code" => 0,"error" => $this->messages['success']);
    }

	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "attendance_type";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = $this->getTakeLeavRoleType()->get();
		$listDb = $this->getOfficerName($listDb);
		$total = count($listDb);

        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'attendance_type':
                        $listDb = $listDb->where('attendance_type','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }   

        $listDb = $listDb;
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"           	=> $row->Id,
                "attendance_type"   		=> $row->attendance_type,
				"officer_id"	=> $row->mef_viewers,
				"creator" 	=> $row->creator,
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    public function getDataByRowId($id){
//        return DB::table('v_take_leave_role_type')->where('Id', $id)->first();
        return DB::select(DB::raw("call get_take_leave_role_type('".$id."');"));
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
	public function getAllDepartmentBySecretariatId($mef_secretariat_id,$id=''){
        $arrList = DB::table('mef_department')->OrderBy('Name', 'ASC');
		if($this->userSession->mef_general_department_id >0){
			$arrList = $arrList->where('mef_secretariat_id',$mef_secretariat_id);
		}
		if($id!=''){
            $arrList=$arrList->where('id',$id);
        }
		$arrList = $arrList->get();
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
	public function getTakeLeavRoleType($id=''){
		
		$list_type = DB::table('v_take_leave_role_type as v_take')
				->select('v_take.*','ad_user.user_name as creator')
				->join('mef_user as ad_user', 'ad_user.id', '=', 'v_take.mef_officer_id');
		if($this->userSession->mef_general_department_id >0){
			$list_type = $list_type->where('mef_officer_id',$this->userSession->id);
		}
				
		return $list_type;
	}
	public function getAttendanceViewer($mef_general_department_id=''){
		
		$list_type = DB::table('v_mef_officer')
			->select('full_name_kh','Id','position')
			->where('general_department_id',$mef_general_department_id)
			->where('department_id',$this->userSession->mef_department_id)
			->whereNull('approve')
			->where('active',1)
			->orderBy('position_order', 'asc')
			->get();
		$arr = array(array("text"=>"", "value" => ""));
        foreach($list_type as $row){
            $arr[] = array(
                'text' 	=> $row->full_name_kh.'   ( '.$row->position.' )',
                "value" => $row->Id
            );
        }
        return json_encode($arr);	
		
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
			$data[$key]->status = $mef_s;
		}
		return $data;
	}
	public function getAllSecretariatByMinistry($ministryId=''){
		$ministryId = $this->userSession->mef_general_department_id;
		$arrList = DB::table('mef_secretariat')
				->orderBy('Name', 'DESC');
		if($ministryId != '' && $ministryId >0){
			$arrList = $arrList->where('Id',$ministryId);
		}
		$arrList = $arrList->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function getDepartmentBySecretariatId($mef_department_id=''){
		
		if($this->userSession->mef_general_department_id ==0){
			$arrList = DB::table('mef_department')->where('mef_secretariat_id',$mef_department_id)->orderBy('Id', 'DESC')->get();
			
		}else{
			$mef_department_id = $this->userSession->mef_department_id;
			$arrList = DB::table('mef_department')->where('Id',$mef_department_id)->orderBy('Id', 'DESC')->get();
		}
        
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	
    public function getOfficeByDepartmentId($departmentId){
        $arrList = DB::table('mef_office')->where('mef_department_id',$departmentId)->orderBy('Id', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
			if($row->Abbr == ''){
				$text = $row->Name;
			} else {
				$text = $row->Name.'-'.$row->Abbr;
			}
            $arr[] = array(
                'text' 	=> $text,
                "value" => $row->Id
            );
        }
        return $arr;
    }
	public function getOfficerByOfficeId($officeId='',$departmentId=''){
		
        $arrList = DB::table('v_mef_officer')->where('active',1)->where('office_id',$officeId)->whereNull('approve')->orderBy('Id', 'DESC')->get();
		if($departmentId!=''){
			$arrList = DB::table('v_mef_officer')->where('active',1)->where('department_id',$departmentId)->whereNull('approve')->orderBy('Id', 'DESC')->get();
		}
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->full_name_kh,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function getAllMinistry(){
        $arrList = DB::table('mef_ministry')->orderBy('Name', 'ASC')->get();
        $arr = array();
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->Name,
                "value" => $row->Id
            );
        }
        return $arr;
    }
	public function getPositionById($id){
		$arrList = DB::table('mef_position')
				->select('NAME AS Name')
				->where('Id',$id)->first();
		if($arrList != null){
			return $arrList;
		}else{
			return array();
		}
	}
	public function getAllClassRank(){
        $arrList = DB::table('mef_class_ranks')->orderBy('Order', 'ASC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function getPosition(){
        $arrList = DB::table('mef_position')->orderBy('ORDER_NUMBER', 'ASC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->NAME,
                "value" =>$row->ID
            );
        }
        return $arr;
    }
	
	public function search($param){
		$arrList = DB::table('v_mef_take_leave')
			->orderBy('take_date', 'ASC')
			->where('status',1);
		if(isset($param['mef_secretariat_id']) && $param['mef_secretariat_id']!=''){
			$arrList= $arrList->where('mef_secretariat_id',$param['mef_secretariat_id']);
		}
		if(isset($param['mef_department_id']) && $param['mef_department_id']!=''){
			$arrList= $arrList->where('mef_department_id',$param['mef_department_id']);
		}
		if(isset($param['mef_position_id']) && $param['mef_position_id']!=''){
			$arrList= $arrList->where('mef_position_id',$param['mef_position_id']);
		}
		if(isset($param['started_dt']) && $param['started_dt']!=''){
			$start_date = str_replace('/', '-', $param["started_dt"]);
			$start_date = date('Y-m-d', strtotime($start_date));
			$arrList= $arrList->where('take_date','>=',$start_date);
		}
		if(isset($param['end_dt']) && $param['end_dt']!=''){
			$end_date = str_replace('/', '-', $param["end_dt"]);
			$end_date = date('Y-m-d', strtotime($end_date));
			$arrList= $arrList->where('take_date','<=',$end_date);
		}
		if(isset($param['mef_office_id']) && $param['mef_office_id']!=''){
			$arrList= $arrList->where('mef_office_Id',$param['mef_office_id']);
		}
		if(isset($param['mef_officer_id']) && $param['mef_officer_id']!=''){
			$arrList= $arrList->where('officer_id_sender',$param['mef_officer_id']);
		}
		
		if(!isset($param['mef_officer_id']) || $param['mef_officer_id'] ==''){
			$arrList= $arrList->select('*',DB::raw('count(*) as total_dt'));
			$arrList= $arrList->groupBy('officer_id_sender');
			
		}
		// return $param;
		$arrList= $arrList->get();
		return $arrList;
	}
	public function export($data){
		
		Excel::create('export_schedule', function($excel) use ($data) {	
			$excel->sheet('excel', function($sheet) use ($data) {
				$data_cell=array();
				foreach ($data as $key => $values) {
					$data_cell[$key]["ល.រ"] = $values->meeting_date;
					$data_cell[$key]["គោត្តនាម-នាម"] = $values->meeting_time;
					$data_cell[$key]["ជាអក្សរឡាតាំង"] = $values->meeting_leader_name;
					$data_cell[$key]["លេខទូរស័ព្ទ"] = $values->meeting_objective;
					$data_cell[$key]["ការិយាល័យ"] = $values->meeting_location;
					$data_cell[$key]["ចំនួនថ្ងៃឈប់"] = $values->all == 1 ? "អ្នកចូលរួមទាំងអស់" : $this->getListAttendeeNameOnly($values->Id);
				}
				$sheet->fromArray($data_cell);
				$sheet->setFontFamily('Khmer MEF1');
				$countDataPlush1 = count($data) + 1;
				$sheet->setBorder('A1:F'.$countDataPlush1, 'thin');
			});
		})->export('xls');
	}
	function exportMeetingData($request_all){
		$start_date = str_replace('/', '-', $request_all["start_date"]);
		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = str_replace('/', '-', $request_all["end_date"]);
		$end_date = date('Y-m-d', strtotime($end_date));
		$listDb = DB::table('mef_meeting AS meeting')
					->join('mef_meeting_leader', 'meeting.mef_meeting_leader_id', '=', 'mef_meeting_leader.Id')
					->select('meeting.*', 'mef_meeting_leader.Name as meeting_leader_name');
		if($this->userSession->moef_role_id != 1){
			$listDb = $listDb->where('meeting.create_by_user_id',$this->userSession->id);
		}
		$listDb = $listDb->where('meeting.meeting_date','>=',$start_date);
		$listDb = $listDb->where('meeting.meeting_date','<=',$end_date);
		$listDb = $listDb->get();
		$data 	= $listDb;
		return $data;
	}
	
	function dataBeauty($data){
		foreach ($data as $key => $values) {
			
		}
	}
}
?>