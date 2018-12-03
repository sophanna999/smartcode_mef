<?php

namespace App\Models\BackEnd\GiveRoomAccess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Config;
class GiveRoomAccessModel
{

    public function __construct()
    {
        $this->constant = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
    }
    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "mef_personal_information.FULL_NAME_KH";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;


        $listDb = DB::table('mef_using_room')
            ->join('mef_personal_information', 'mef_personal_information.MEF_OFFICER_ID', '=', 'mef_using_room.mef_officer_id')
            ->join('mef_meeting_room', 'mef_meeting_room.id', '=', 'mef_using_room.meeting_room_id')
            ->select(
                'mef_using_room.id as id',
                'mef_using_room.mef_officer_id as mef_officer_id',
                'mef_personal_information.FULL_NAME_KH as FULL_NAME_KH',
                'mef_using_room.meeting_room_id as meeting_room_id',
//                'mef_meeting_room.name as name',
                DB::raw('GROUP_CONCAT(mef_meeting_room.name SEPARATOR \', \') as name')
            )
            ->groupBy('mef_using_room.mef_officer_id')
            ->orderBy('mef_using_room.id','DESC');

        $total = count($listDb->get());
        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'mef_personal_information.FULL_NAME_KH':
                        $listDb = $listDb->where('mef_personal_information.FULL_NAME_KH','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'mef_meeting_room.name':
                        $listDb = $listDb->where('mef_meeting_room.name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }
        $listDb = $listDb
            ->orderBy($sort, $order)
            ->take($limit)
            ->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                'id'                 =>$row->mef_officer_id,
                'mef_officer_id'                 =>$row->mef_officer_id,
                'FULL_NAME_KH'         =>$row->FULL_NAME_KH,
                'meeting_room_id'        =>$row->meeting_room_id,
                'name'                   =>$row->name,
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }


    public function postSave($data){
        $officer_id = $data['officer_id'];
        if($data['officer_id'] != null){
            //check if this officer already has in this room
            $room_id_array = explode(',', $data['room']);//convert string to array

            DB::table('mef_using_room')//delete all except array id
                ->whereNotIn('meeting_room_id',$room_id_array)
                ->where('mef_officer_id',$officer_id)
                ->delete();

            //loop check and insert
            foreach ($room_id_array as $item){
                $chk = DB::table('mef_using_room')->where(['mef_officer_id'=>$officer_id,'meeting_room_id'=>$item])->get();
                if(count($chk) == 0 ){ //insert
                    DB::table('mef_using_room')->insert([
                        ['mef_officer_id' => $officer_id, 'meeting_room_id' => $item,'create_date'=>date('y-m-d')],
                    ]);
                }
            }
            return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
        }else{
            return json_encode(array("code" => 0, "message" => trans('general.something_went_wrong'), "data" => ""));
        }
    }
    public function postDelete($listId){
        if($listId != null){
            DB::table('mef_using_room')//delete all except array id
            ->whereIn('mef_officer_id',$listId)
                ->delete();
            return array("code" => 2,"message" => trans('trans.success'));
        }else{
            return json_encode(array("code" => 0, "message" => trans('general.something_went_wrong'), "data" => ""));
        }
    }




    public function getDataByRowId($id){
        return DB::table($this->table['mef_using_room'])->where('id', $id)->first();
    }








    public function isCurrentUser($id){
        $sessionUserId = Session::get('sessionUser')->id;
        return $sessionUserId == $id ? 1:0;
    }

    public function getUserName(){
        $obj =  DB::table($this->table['MEF_USER'])
            ->select('user_name')
            ->get();
        $arr = array();
        foreach($obj as $row){
            $arr[] = $row->user_name;
        }
        return json_encode($arr);
    }
    public function getRoleIdByName($role){
        $row = DB::table($this->table['MEF_ROLE'])->select('id')->where('role',$role)->first();
        return $row->id;
    }
    public function cheekUserName($id,$userName=''){
    	if($id == 0){
		    $cheek = DB:: table($this->table['MEF_USER'])
			    ->where('user_name',$userName)
			    ->first();
	    }else{
		    $cheek = DB:: table($this->table['MEF_USER'])
			    ->where('mef_officer_id',$id)
			    ->first();
	    }

        if(count($cheek)){
            $msg['success'] = true;
        } else{
            $msg['success'] = false;
        }
        return $msg;
    }

    public function postSaveChangeUserPassword($user_id,$newPassword){
        DB::table($this->table['MEF_USER'])
            ->where('id', $user_id)
            ->update(['password'   => str_replace("$2y$", "$2a$", bcrypt($newPassword)), 'salt'  => $newPassword]);
        return Redirect::back();
    }

    public function ajaxSaveResetPassword($user_id,$newPassword){
        $row = DB::table($this->table['MEF_USER'])
            ->where('id', $user_id)
            ->update(['password'  =>bcrypt($newPassword)]);
        if($row == true){
            return json_encode(array("code" => 1, "message" =>trans('trans.success'), "data" => ""));
        }
    }

    public function getAllDepartments(){
        $obj =  DB::table('mef_department')
            ->select('Name')
            ->orderBy('Id','ASC')
            ->get();
        $arr = array();
        foreach($obj as $row){
            $arr[] = $row->Name;
        }
        return $arr;
    }
    public function listAllGeneralDepartment(){
        $obj =  DB::table('mef_secretariat')
            ->select('Name')
            ->orderBy('Id','ASC')
            ->get();
        $arr = array();
        foreach($obj as $row){
            $arr[] = $row->Name;
        }
        return $arr;
    }

    //sample code for get list role
//    public function getListRole(){
//        $obj =  DB::table('mef_role')
//            ->select(
//                'id AS value',
//                'role AS text')
//            ->orderBy('Id','ASC')
//            ->get();
//        return $obj;
//    }

    //sample code for get list roles when update data
    public function getListRoleCheck($id){
        $obj = array();
        if(!empty($id)){
            foreach ($id as $key => $value){
                $obj[] =  array(
                    "text" => DB::table('mef_role')->select('role')->where('id',$value)->first(),
                    "value" => $value,
                );
            }
        }
        return $obj;
    }

    //sample code for get list users
    public function getListUser($id){
        $arr = array(array('text'=>'','value'=>''));
        $obj = DB::table('v_get_unit')->Where('mef_user_id','=',$id)->get();
        $mef_member_position_id = empty($obj[0]->mef_member_position_id) ? "''" : $obj[0]->mef_member_position_id;
        $obj_user = DB::select(DB::raw("select mef_user_id as value
                                                  ,mef_full_name as text from v_get_unit
                                            where mef_position_id in (".$mef_member_position_id.") and 
                                                  mef_user_id is not null and 
                                                  mef_user_id Not In (".$id.")
                                            order by mef_office_name asc"));
        //print_r($obj_user); exit();
        return array_merge($arr,$obj_user);
    }

    //sample code for get list users when update data
    public function getListUserCheck($id){
        $obj = array();
        if(!empty($id)){
            foreach ($id as $key => $value){
                $obj[] =  array(
                    "text" => DB::table('mef_user')->select('user_name')->where('id',$value)->first(),
                    "value" => $value,
                );
            }
        }
        return $obj;
    }

    //sample code for get role join
    public function getRoleJoin(){
        $obj =  DB::table('mef_department')
            ->select('Name')
            ->orderBy('Id','ASC')
            ->get();
        $arr = array();
        foreach($obj as $row){
            $arr[] = $row->Name;
        }
        return $arr;
    }

    //sample code for get list Ministry
    public function getlistMinistry($id){
        $obj =  DB::table('mef_ministry')
            ->select(
                'Id AS value',
                'Name AS text')
            ->where('Id','=',$id)
            ->orderBy('Id','ASC')
            ->get();
        return $obj;
    }

	public function getlistAllMinistry(){
		$arr = array(array('text'=>'','value'=>'0'));
		$obj =  DB::table('mef_ministry')
			->select(
				'Id AS value',
				'Name AS text')
			->orderBy('Id','ASC')
			->get();
		return array_merge($arr,$obj);
	}

    //sample code for get list Secretary
    public function getlistSecretary($id){
        $obj =  DB::table('mef_secretariat')
            ->select(
                'Id AS value',
                'Name AS text')
            ->where('Id','=',$id)
            ->orderBy('Id','ASC')
            ->get();
        return $obj;
    }

	public function getlistAllSecretary(){
		$arr = array(array('text'=>'','value'=>'0'));
		$obj =  DB::table('mef_secretariat')
			->select(
				'Id AS value',
				'Name AS text')
			->orderBy('Id','ASC')
			->get();
		return array_merge($arr,$obj);
	}

    //sample code for get list Department
    public function getlistDepartment($id){
        $obj =  DB::table('mef_department')
            ->select(
                'Id AS value',
                'Name AS text')
            ->where('Id','=',$id)
            ->orderBy('Id','ASC')
            ->get();
        return $obj;
    }
	public function getlistAllDepartment(){
		$arr = array(array('text'=>'','value'=>'0'));
		$obj =  DB::table('mef_department')
			->select(
				'Id AS value',
				'Name AS text')
			->orderBy('Id','ASC')
			->get();
		return array_merge($arr,$obj);
	}

    //sample code for get list Officer
    public function getlistOffice($id){
        $obj =  DB::table('mef_office')
            ->select(
                'Id AS value',
                'Name AS text')
            ->where('Id','=',$id)
            ->orderBy('Id','ASC')
            ->get();
        return $obj;
    }
	public function getAlllistOffice(){
		$arr = array(array('text'=>'','value'=>'0'));
		$obj =  DB::table('mef_office')
			->select(
				'Id AS value',
				'Name AS text')
			->orderBy('Id','ASC')
			->get();
		return array_merge($arr,$obj);
	}

    //sample code for get list users
    public function getListOfficer(){
        $arr = array(array('text'=>trans('trans.none'),'value'=>'0'));
        $obj =  DB::table('v_get_unit')
            ->select(
                'mef_officer_id AS value',
                'mef_full_name AS text')
            ->orderBy('mef_office_name','ASC')
            ->get();
        return array_merge($arr,$obj);
    }

    //Filter Data Office Of Unit(Ministry,secretary,Department,Office)
    public function getUnit($mef_officer_id){
        $obj = DB::table('v_get_unit')->Where('mef_officer_id','=',$mef_officer_id)->get();
        $arr_ministry = array();
        $arr_secretarial = array();
        $arr_department = array();
        $arr_office = array();
        $arr_user_check = array();
        foreach($obj as $row){
            // add value column to array
            $arr_ministry[] =  array(
                'value' =>$row->ministry_id,
                'text'  =>$row->ministry_name
            );
            $arr_secretarial[] =  array(
                'value' =>$row->secretariat_id,
                'text'  =>$row->secretariat_name
            );
            $arr_department[] =  array(
                'value' =>$row->department_id,
                'text'  =>$row->department_name
            );
            $arr_office[] =  array(
                'value' =>$row->office_id,
                'text'  =>$row->office_name
            );
            //check condition for filter user
            //$mef_member_position_id = empty($obj[0]->mef_member_position_id) ? "''" : $obj[0]->mef_member_position_id;
            $obj_user = DB::select(DB::raw("select mef_user_id as value, mef_full_name as text from v_get_unit
                                               where mef_user_id is not null order by mef_office_name asc"));
        }
        return array(
            'ministry'          =>$arr_ministry,
            'secretarial'       =>$arr_secretarial,
            'department'        =>$arr_department,
            'office'            =>$arr_office,
            'user_check'        =>$arr_user_check,
            'officer_username'  =>$obj[0]->mef_office_name,
            'position_name'     =>$obj[0]->mef_position_name,
            'user'              =>$obj_user
        );
    }







    public function getMeetingRoom(){
        $obj =  DB::table('mef_meeting_room')
            ->select(
                'id AS value',
                'name AS text')
            ->where('mef_role_id','=',1)
            ->orderBy('id','ASC')
            ->get();
        return $obj;
    }

    public function getRoomSelected($officer_id){
        $obj =  DB::table('mef_using_room')->where('mef_officer_id',$officer_id)->get();
        return $obj;
    }

}
?>