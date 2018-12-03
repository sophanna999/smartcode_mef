<?php

namespace App\Models\BackEnd\Mission;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class MissionTypeModel
{

    public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
        $this->member = explode(',',$this->userSession->mef_member_id);
        array_push($this->member,$this->userSession->id);
    }
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "order_number";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = DB::table('mef_mission_type')
					->join('mef_user', 'mef_mission_type.create_by_user_id', '=', 'mef_user.id')
					->select('mef_mission_type.*', 'mef_user.user_name');
        $listDb = $listDb->whereIn('mef_mission_type.create_by_user_id',$this->member);
		$total = count($listDb->get());

        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'name':
                        $listDb = $listDb->where('mef_mission_type.Name','LIKE','%'.$arrFilterValue.'%');
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
                "id"           	=> $row->id,
                "name"   		=> $row->name,
				"user_name"		=> ucfirst($row->user_name),
				"order_number"  => $row->order_number
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
	public function postSave($data){
		/* Validator Name */
		$count_query = DB::table('mef_mission_type')->where('name', $data['name']);
		// $count_query = $count_query->where('mef_role_id',intval($this->userSession->moef_role_id));
		$count_query = $count_query->where('id','<>',intval($data['id']))->count();
		if($count_query > 0){
			return json_encode(array("code" => 0, "message" => trans('mission.mission_type_exist'), "data" => ""));
		}
		/* End Validator Name */
        if($data){
            unset($data['_token']);
        }
		$array = array(
			"name" 				=> $data['name'],
			"create_by_user_id" => intval($this->userSession->id),
            "mef_role_id"       => intval($this->userSession->moef_role_id),
			"order_number" 		=> intval($data['order_number'])
		);
        if($data['id']==0){
            /* Save data */
			$id = DB::table('mef_mission_type')->insertGetId($array);
            /* End Save data */
        }else{
			DB::table('mef_mission_type')->where('id',intval($data['id']))->update($array);
			$id = intval($data['id']);
        }
		$query = DB::table('mef_mission_type')->where('id',$id)->first();
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => $query));
    }

    public function postDelete($listId){
        foreach ($listId as $id){
            $is_delete = DB::table('mef_mission')->where('mef_mission_type_id', $id)->first();
            if(!$is_delete){
                DB::table('mef_mission_type')->where('id',$id)->delete();
            }
        }
        return array("code" => 1,"message" => trans('trans.success'));
    }



    public function getDataByRowId($id){
        return DB::table('mef_mission_type')->where('id', $id)->first();
    }
}
?>
