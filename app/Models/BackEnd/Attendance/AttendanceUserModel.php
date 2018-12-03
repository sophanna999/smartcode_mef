<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AttendanceUserModel
{

    public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
		$this->member = explode(',',$this->userSession->mef_member_id);
		array_push($this->member,strval($this->userSession->id));//dd($this->member);
    }
	public function postSave($data){
        if($data){
            unset($data['_token']);
        }
        if($data['Id']==0){
            /* Save data */
			$result = DB::table('mef_take_leave_user_role')->where('officer_id', $data['officer_id'])->count();
			if($result >0){
				return json_encode(array("code" => 0, "message" => $this->messages['take-leave-type']."មិនអនុញ្ញាតិឲ្យដូចគ្នា", "data" => ""));
			}
			
			$data['create_by']= $this->userSession->id;
			// $data['mef_role_id']= $this->userSession->moef_role_id;
			DB::table('mef_take_leave_user_role')->insert($data);
            /* End Save data */
        }else{
            DB::table('mef_take_leave_user_role')
				->where('Id', $data['Id'])
				->update([
					'officer_id'		=>$data['officer_id'],
					'take_leave_type_id'		=>$data['take_leave_type_id']
				]);
        }
       
        return json_encode(array("code" => 1, "message" => $this->messages['success'], "data" => ""));
    }
	
    public function postDelete($Id){
        $is_delete = DB::table('mef_take_leave_user_role')->whereIn('Id', $Id)->delete();
		if($is_delete)
			return array("code" => 1,"message" => $this->messages['success']);
		// return array("code" => 0,"error" => $this->messages['success']);
    }

	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "officer_name";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = $this->getTakeLeavUserRole()->get();
		// $listDb = $this->getTitle($listDb);
		$total = count($listDb);

        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'officer_name':
                        $listDb = $listDb->where('officer_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }   

        $list = $listDb;
        
        // foreach($listDb as $row){
            // $list[] = array(
                // "Id"           	=> $row->Id,
                // "officer_name"   		=> $row->officer_name,
				// "officer_id"	=> $row->officer_id,
				// "take_leave_id" 	=> $row->take_leave_titles,
            // );
        // }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    public function getDataByRowId($id){
       return DB::table('v_take_leave_user_role')->where('Id', $id)->first();
        // $row = DB::select(DB::raw("call get_take_leave_user_role('".$id."');"));
    }
	public function getOfficer(){		
		return DB::table('v_mef_officer')->where('is_approve',2)->where('active',1)->whereNull('approve')->orderBy('position_order', 'asc')->get();
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
	public function getTakeLeavType($id='')
    {
        $list_type = DB::table('mef_take_leave_type')
            ->select('Id as value', 'attendance_title as text')
            ->whereIn('created_by',$this->member);

        return json_encode($list_type->get());
    }
	public function getTakeLeavUserRole($id=''){		
		$list_type = DB::table('v_take_leave_user_role as v_take')
				->select('v_take.Id','v_take.creator_id','v_take.officer_name','v_take.take_leave_title AS take_leave_title')				
				->whereIn('v_take.creator_id',$this->member);
		return $list_type;
	}
	public function getAttendanceViewer($mef_general_department_id=''){
		$param = array();
		$user_role = DB::table('mef_take_leave_user_role')
				->select('officer_id')->get();
		foreach($user_role as $key => $value){
			array_push($param,$value->officer_id);
		}
		$list_type = DB::table('v_mef_officer')
			->select('full_name_kh','Id','position')
			->where('general_department_id',$mef_general_department_id)
			->where('department_id',$this->userSession->mef_department_id)
            ->where('is_approve',2)
            ->where('active',1)	
			->whereNull('approve')
			->orderBy('position_order', 'ASC')
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
	public function getTitle($data=''){
		
		foreach($data as $key => $val){
			$mef_viewers = explode(',', $val->take_leave_id);
			$mef_v = '';
			$mef_s = '';
			foreach($mef_viewers as $key1 => $val1){
				$list_data = DB::table('mef_take_leave_role_type')
					->select('attendance_type')
					->where('Id',$val1)
					->first();
				if($mef_v =='' && $list_data!= null){
					$mef_v = $list_data->attendance_type;
				}else{
					if(isset($list_data))
						$mef_v .= ', '.$list_data->attendance_type;
				}
				
				
			}
			$data[$key]->take_leave_titles = $mef_v;
			
		}
		return $data;
	}
}
?>