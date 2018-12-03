<?php

namespace App\Models\BackEnd\Schedule;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class MeetingTypeModel
{

    public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
    }
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "id";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
		$groupId = explode(",",$this->userSession->moef_role_id);
        $listDb = DB::table('mef_meeting_type')
					->leftJoin('mef_user', 'mef_meeting_type.create_by_user_id', '=', 'mef_user.id')
					->select('mef_meeting_type.*', 'mef_user.user_name')
                    ->whereIn('mef_user.moef_role_id',$groupId);
		$total = count($listDb->get());

        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'Name':
                        $listDb = $listDb->where('mef_meeting_type.Name','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'user_name':
                        $listDb = $listDb->where('mef_user.user_name','LIKE','%'.$arrFilterValue.'%');
                        break;	
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }   

        $listDb = $listDb
				->OrderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"           	=> $row->Id,
                "Name"   		=> $row->Name,
				"user_name"		=> ucfirst($row->user_name),
				"order_number"  => $row->order_number
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
	public function postSave($data){
		/* Validator Name */
		$count_query = DB::table('mef_meeting_type')->where('Name', $data['Name']);
		$count_query = $count_query->where('mef_role_id',intval($this->userSession->moef_role_id));
		$count_query = $count_query->where('Id','<>',intval($data['Id']))->count();
		if($count_query > 0){
			return json_encode(array("code" => 0, "message" => trans('schedule.meeting_type_exist'), "data" => ""));
		}
		/* End Validator Name */
        if($data){
            unset($data['_token']);
        }
		$array = array(
			"Name" 				=> $data['Name'],
			"create_by_user_id" => intval($this->userSession->id),
            "mef_role_id"       => intval($this->userSession->moef_role_id),
			"order_number" 		=> intval($data['order_number'])
		);
        if($data['Id']==0){
            /* Save data */
			$id = DB::table('mef_meeting_type')->insertGetId($array);
            /* End Save data */
        }else{
			DB::table('mef_meeting_type')->where('Id',intval($data['Id']))->update($array);
			$id = intval($data['Id']);
        }
		$query = DB::table('mef_meeting_type')->where('Id',$id)->first();
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => $query));
    }
	
    public function postDelete($listId){
        $delId = array();
		foreach ($listId as $id){
            $meeting_id = intval($id);
			$data = DB::table('mef_meeting')->where('mef_meeting_type_id',$meeting_id)->get();
			if(count($data) > 0){
				$delId[] = $data[0]; 
			} else {
			  DB::table('mef_meeting_type')->where('Id',$meeting_id)->delete();
			}
        }
       
		if(count($delId) > 0){
			return array("code" => 0,"message" => trans('schedule.data_in_use'));
		} else {
			return array("code" => 1,"message" => trans('trans.success'));
        }
        
        return array("code" => 1,"message" => trans('trans.success'));
    }

	

    public function getDataByRowId($id){
        return DB::table('mef_meeting_type')->where('Id', $id)->first();
    }
}
?>