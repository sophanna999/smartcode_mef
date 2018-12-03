<?php

namespace App\Models\BackEnd\Schedule;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class MeetingRoomModel
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
		$sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "name";
		$order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
		$offset = $page*$limit;
		$filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
		$groupId = explode(",",$this->userSession->moef_role_id);
//		dd($groupId);
		$listDb = DB::table('mef_meeting_room')
			->leftJoin('mef_user', 'mef_meeting_room.create_by_user_id', '=', 'mef_user.id')
			->select('mef_meeting_room.*', 'mef_user.user_name')
			->whereIn('mef_meeting_room.mef_role_id',$groupId);
		$total = count($listDb->get());
		if($filtersCount>0){
			for ($i=0; $i < $filtersCount; $i++) {
				$arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
				$arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
				switch($arrFilterName){
					case 'Name':
						$listDb = $listDb->where('mef_meeting_room.Name','LIKE','%'.$arrFilterValue.'%');
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
				"Id"           	=> $row->id,
				"Name"   		=> $row->name,
				"user_name"		=> ucfirst($row->user_name),
			);
		}
		return json_encode(array('total'=>$total,'items'=>$list));
	}
	public function postSave($data){
		/* Validator Name */
		$count_query = DB::table('mef_meeting_room')->where('name', $data['name']);
		$count_query = $count_query->where('mef_role_id',intval($this->userSession->moef_role_id));
		$count_query = $count_query->where('Id','<>',intval($data['Id']))->count();
		if($count_query > 0){
			return json_encode(array("code" => 0, "message" => trans('schedule.meeting_room_exist'), "data" => ""));
		}
		/* End Validator Name */
		if($data){
			unset($data['_token']);
		}
		$array = array(
			"name" 				=> $data['name'],
			"create_by_user_id" => intval($this->userSession->id),
			"mef_role_id"       => intval($this->userSession->moef_role_id),
			"create_date" 		=> date('Y-m-d H:i:s'),
			"update_date" 		=> date('Y-m-d H:i:s')
		);
		if($data['Id']==0){
			/* Save data */
			$id = DB::table('mef_meeting_room')->insertGetId($array);
			/* End Save data */
		}else{
			DB::table('mef_meeting_room')->where('id',intval($data['Id']))->update($array);
			$id = intval($data['Id']);
		}
		$query = DB::table('mef_meeting_room')->where('id',$id)->first();
		return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => $query));
	}

	public function postDelete($listId){
		foreach ($listId as $id){
			$is_delete = DB::table('mef_meeting')->where('meeting_location_id', $id)->first();
			if(!$is_delete){
				DB::table('mef_meeting_room')->where('id',$id)->delete();
			}

		}
		return array("code" => 1,"message" => trans('trans.success'));
	}



	public function getDataByRowId($id){
		return DB::table('mef_meeting_room')->where('id', $id)->first();
	}
}
?>