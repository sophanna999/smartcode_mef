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

class AttendanceApproveModel extends BackEndModel

{
    public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
		$this->member = explode(',',$this->userSession->mef_member_id);
		array_push($this->member,$this->userSession->id);
    }
	public function postSave($data){
		$inData = $data['input'];
        if($data['Id']==0){
            /* Save data */
			// $result = DB::table('mef_take_leave_type')            
			// ->where('attendance_title', $inData['attendance_title'])
            // ->where('mef_ministry_id', $this->userSession->mef_ministry_id)
            // ->where('mef_general_department_id', $this->userSession->mef_general_department_id)
            // ->where('mef_department_id', $this->userSession->mef_department_id)
            // ->whereIn('created_by',$this->member)
            // ->count();
			// if($result >0){
				// return json_encode(array("code" => 0, "message" => $this->messages['take-leave-type']."មិនអនុញ្ញាតិឲ្យដូចគ្នា", "data" => ""));
			// }

			$inData['created_by']= $this->userSession->id;
			
			$insertGetId =	DB::table('mef_take_leave_type')->insertGetId($inData);		
			
            /* End Save data */
        }else{
			$insertGetId = $data['Id'];
			
			DB::table('mef_take_leave_approver')->where('take_leave_id',$data['Id'])->delete();
			DB::table('mef_take_leave_type_by_role')->where('take_leave_id',$data['Id'])->delete();
			DB::table('mef_take_leave_type')
			->where('Id', $data['Id'])
			->update($inData);
			
        }
		foreach(explode(',',$data['take_leave_role']) as $key =>$value){
			$ptrole_array = array(
				'take_leave_id' =>$insertGetId,
				'take_leave_role_id' =>$value
			);
			DB::table('mef_take_leave_type_by_role')->insert($ptrole_array);
		}
		foreach($data['officer_id'] as $key =>$value){
			$take_leave_approve[$key] = array(
											'take_leave_id' =>$insertGetId,
											'approver_id' =>$value,
											'approver_order' =>$data['approve_order'][$key],
											'order_id' =>intval(str_replace('index','',$key))+1
										);
			
		}
		if(sizeOf($take_leave_approve)>0){
			DB::table('mef_take_leave_approver')->insert($take_leave_approve);
		}
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }

    public function postDelete($Id){
        $is_delete = DB::table('mef_take_leave_type')->whereIn('Id', $Id)->delete();
		if($is_delete){
			
			DB::table('mef_take_leave_type_by_role')->whereIn('take_leave_id', $Id)->delete();
			DB::table('mef_take_leave_approver')->whereIn('take_leave_id', $Id)->delete();
			return array("code" => 1,"message" => trans('trans.success'));
		}
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
	public function getPositionByTakeLeaveType($id){
		return $arrList = DB::table('mef_take_leave_type_by_position')->where('mef_take_leave_type_id',$id)->get();
	}
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "attendance_title";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = $this->getTakeLeavType()->get();
		
		$total = count($listDb);

        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'attendance_title':
                        $listDb = $listDb->where('attendance_title','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }

        $listDb = $listDb;
        
        return json_encode(array('total'=>$total,'items'=>$listDb));
    }

    public function getDataByRowId($id){
       return DB::table('mef_take_leave_type')->where('Id', $id)->first();
        // return  DB::select(DB::raw("call get_take_leave_role_type('".$id."');"));
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
        $arrList = DB::table('mef_department')->where('mef_secretariat_id',$mef_secretariat_id)->OrderBy('Name', 'ASC');
        if($id!=''){
            $arrList=$arrList->where('id',$id);
        }
        $arrList=$arrList->get();
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
	public function getTakeLeavType($id=''){

		$list_type = DB::table('mef_take_leave_type as v_take')
				->select(
					'v_take.title',
					'v_take.Id',
					
					'v_take.description'
				)
				->whereIn('v_take.created_by',$this->member);

		return $list_type;
	}
	public function getAttendanceViewer($mef_general_department_id=''){
		$list_type = DB::table('v_mef_officer')
			->select('full_name_kh','Id','position')
			->where('general_department_id',$mef_general_department_id)
			->where('department_id',$this->userSession->mef_department_id)
			->where('is_approve',2)
			->where('active',1)
			->whereNull('approve')
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
				$list_data = DB::table('mef_position')
					->select('NAME')
					->where('ID',$val1)
					->first();
				if($mef_v =='' && $list_data!= null){
					$mef_v = $list_data->NAME;
				}else{
					if(isset($list_data))
						$mef_v .= ','.$list_data->NAME;
				}

				$list_status = DB::table('mef_take_leave_status')
					->select('status')
					->where('takeleave_id',$val->Id)
					->where('officer_id',$val1)
					->first();
				// $mef_s = $val->Id;
				if(isset($list_status->status) && $list_status->status==1){
					if($mef_s ==''){
						$mef_s = $list_data->NAME;
					}else{
						$mef_s .= ','.$list_data->NAME;
					}
				}
			}
			$data[$key]->mef_viewers = $mef_v;
			$data[$key]->status = $mef_s;
		}
		return $data;
	}
	public function getOfficeByDepartmentId($departmentId){
        $arrList = DB::table('mef_office')->where('mef_department_id',$departmentId)->orderBy('Id', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function getPosition($value='')
	{
		$arrList = DB::table('mef_position')->orderBy('ORDER_NUMBER', 'ASC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->NAME,
                "value" =>$row->ID
            );
        }
        return json_encode($arr);
	}
	public function getOfficeApprove($take_id='',$pos_id=array(10))
	{
		# ទាញយកឈ្មោះអ្នកប្រើប្រាស់ដែលមានសិទ្ធអនុញ្ញាតិច្បាប់
		$arrList = DB::table('v_mef_officer')
			->select(
				DB::raw('CONCAT(full_name_kh," (",position," )") AS text'),
				'Id as value'
			)
			->where('active',1)
			->whereNull('approve')
			->whereIn('position_id',$pos_id)
			->orderBy('position_order', 'DESC');
		if($take_id !=''){
			$arrList = $arrList->where('Id',$take_id);
		}
		$arrList	=	$arrList->get();
		$array = array(array("text"=>"", "value" => ""));
		$result = array_merge($array, $arrList);

		return json_encode($result);
	}
	public function getTakeLeaveApprover($take_id='')
		{
		# ទាញយកឈ្មោះអ្នកប្រើប្រាស់ដែលមានសិទ្ធអនុញ្ញាតិច្បាប់
		$arrList = DB::table('mef_take_leave_approver')->orderBy('order_id', 'ASC');
		if($take_id !=''){
			$arrList = $arrList->where('take_leave_id',$take_id);
		}
		$result	=	$arrList->get();
		return ($result);
	}
	public function getTakeLeaveRole($take_id='')
		{
		# ទាញយកឈ្មោះអ្នកប្រើប្រាស់ដែលមានសិទ្ធអនុញ្ញាតិច្បាប់
		$arrList = DB::table('mef_take_leave_type_by_role');
		if($take_id !=''){
			$arrList = $arrList->where('take_leave_id',$take_id);
		}
		$result	=	$arrList->get();
		return ($result);
	}
	
	public function getResponsibleOrder(){
		# លំដាប់នៃអ្នកអនុញ្ញាតិច្បាប់
		$db_list = array(array(
                'text' 	=> 'អនុញ្ញាតិ',
                "value" => 1
            ),array(
                'text' 	=> 'ផ្ទេរសិទ្ធ',
                "value" => 2
            ));
		return json_encode($db_list);
  
	}
}
?>
