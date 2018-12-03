<?php

namespace App\Models\BackEnd\Schedule;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class MeetingLeaderModel{
	
    public function __construct(){
        $this->constant = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
		$this->messages = Config::get('constant');
    }
	
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "order_number";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

		$groupId = explode(",",$this->userSession->moef_role_id);

		$listDb = DB::table('mef_meeting_leader')
					->leftJoin('mef_user', 'mef_meeting_leader.create_by_user_id', '=', 'mef_user.id')
					->select('mef_meeting_leader.*', 'mef_user.user_name')
                    ->where('mef_meeting_leader.mef_role_id',$groupId);
		$total = count($listDb->get());
        
		if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'Name':
                        $listDb = $listDb->where('mef_meeting_leader.Name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'email':
                        $listDb = $listDb->where('mef_meeting_leader.email','LIKE','%'.$arrFilterValue.'%');
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
        $listDb = $listDb->get();//dd($listDb);
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"           		=> $row->Id,
                "Name"   			=> $row->Name,
                "email"   			=> $row->email,
				"user_name"			=> ucfirst($row->user_name),
                "order_number"  	=> $row->order_number
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
	
	public function postSave($data){
		$array = array(
			"Name"              => $data['Name'],
            "email"             => $data['email'],
			"create_by_user_id" => intval($this->userSession->id),
            'mef_role_id'       => intval($this->userSession->moef_role_id),
			"order_number"      => intval($data['order_number'])
		);
		if(intval($data['Id']) > 0){
			DB::table('mef_meeting_leader')->where('Id',intval($data['Id']))->update($array);
			$id = intval($data['Id']);
		} else {
			$id = DB::table('mef_meeting_leader')->insertGetId($array);
		}
		$query = DB::table('mef_meeting_leader')->where('Id',$id)->first();
		return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => $query));
    }
	
    public function postDelete($listId){
		$create_by_user_id = $this->userSession->id;
		$delId = array();
		foreach ($listId as $id){
			$data = DB::table('mef_meeting')->where('mef_meeting_leader_id',$id)->get();
			if(count($data) > 0){
				$delId[] = $data[0]; 
			} else {
			   DB::table('mef_meeting_leader')->where('create_by_user_id',$create_by_user_id)->where('Id',$id)->delete();
			}
        }
		if(count($delId) > 0){
			return array("code" => 0,"message" => trans('schedule.data_in_use'));
		} else {
			return array("code" => 1,"message" => trans('trans.success'));
		}
    }
	
	public function getDataByRowId($id){
        return DB::table('mef_meeting_leader')->where('Id', $id)->first();
    }
	public function checkLeaderEmail($email){
	    $array = array();
        $row = DB:: table('mef_meeting_leader')->where('email',$email)->first();
        if(count($row)){
            $array[] = array(
                'success'   =>true,
                'email'      =>$row->email
            );
        }
        else{
            $array[] = array(
                'success'   =>false,
                'email'     =>''
            );
        }
        return $array;
    }
}
?>