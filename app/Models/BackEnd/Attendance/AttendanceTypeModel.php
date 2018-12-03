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

class AttendanceTypeModel extends BackEndModel

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
			
			$result = DB::table('mef_take_leave_role_type')
            ->where('attendance_type', $inData['attendance_type'])
            ->where('mef_ministry_id', $this->userSession->mef_ministry_id)
            ->where('mef_general_department_id', $this->userSession->mef_general_department_id)
            ->where('mef_department_id', $this->userSession->mef_department_id)
            ->whereIn('created_by',$this->member)
            ->count();
			if($result >0){
				return json_encode(array("code" => 0, "message" => $this->messages['take-leave-type']."មិនអនុញ្ញាតិឲ្យដូចគ្នា", "data" => ""));
			}
			
			$inData['mef_ministry_id']= $this->userSession->mef_ministry_id;
			$inData['mef_general_department_id']= $this->userSession->mef_general_department_id;
			$inData['created_by']= $this->userSession->id;
			$inData['is_priority']= isset($inData['is_priority'])?1:0;
			
			$insertGetId =	DB::table('mef_take_leave_role_type')->insertGetId($inData);
			/* array postion and take leave role type*/
			$pt_array = array(); 
			
            /* End Save data */
        }else{
			$insertGetId = $data['Id'];
			$inData['mef_ministry_id']= $this->userSession->mef_ministry_id;
			$inData['mef_general_department_id']= $this->userSession->mef_general_department_id;
			
			DB::table('mef_take_leave_role_type')
			->where('Id', $insertGetId)
			->update($inData);
			DB::table('mef_take_leave_role_type_by_position')->where('mef_take_leave_type_id', $insertGetId)->delete();
        }
		foreach(explode(',',$data['position']) as $key =>$value){
			$pt_array = array(
				'mef_take_leave_type_id' =>$insertGetId,
				'position_id' =>$value
			);
			DB::table('mef_take_leave_role_type_by_position')->insert($pt_array);
		}
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
	public function getPositionByTakeLeaveType($id){
		return $arrList = DB::table('mef_take_leave_role_type_by_position')->where('mef_take_leave_type_id',$id)->get();
	}
    public function postDelete($Id){
        $is_delete = DB::table('mef_take_leave_role_type')->whereIn('Id', $Id)->delete();
		if($is_delete){
			DB::table('mef_take_leave_role_type_by_position')->where('mef_take_leave_type_id', $Id)->delete();
			DB::table('mef_take_leave_approver')->whereIn('take_leave_id', $Id)->delete();
			return array("code" => 1,"message" => trans('trans.success'));
		}
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
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "attendance_type";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = $this->getTakeLeavRoleType()->get();
		// $listDb = $this->getOfficerName($listDb);
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
        return json_encode(array('total'=>$total,'items'=>$listDb));
    }

    public function getDataByRowId($id){
		return $this->getTakeLeavRoleType($id)->first();
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
	public function getTakeLeavRoleType($id=''){

		$list_type = DB::table('mef_take_leave_role_type as v_take')
			->select(
				'v_take.*',
				'dep.Name as department_id',
				'off.Name as office_id'
			)
			->leftJoin('mef_department as dep','dep.id','=','v_take.mef_department_id')
			->leftJoin('mef_office as off','off.id','=','v_take.mef_office_id')
			->whereIn('v_take.created_by',$this->member);
		if($id!=''){
			$list_type = $list_type->where('v_take.Id',$id);
		}
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
  public function getOfficeApprove($take_id='')
  {
    # ទាញយកឈ្មោះអ្នកប្រើប្រាស់ដែលមានសិទ្ធអនុញ្ញាតិច្បាប់
    $arrList = DB::table('v_mef_officer')
		->select(
			DB::raw('CONCAT(full_name_kh," (",position," )") AS text'),
			'Id as value'
		)->whereNull('approve')
		->where('active',1)
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
    $arrList = DB::table('mef_take_leave_approver')->orderBy('order_id', 'DESC');
	if($take_id !=''){
		$arrList = $arrList->where('take_leave_id',$take_id);
	}
	$result	=	$arrList->get();
    return ($result);
  }
  
  
}
?>
