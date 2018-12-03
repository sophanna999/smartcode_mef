<?php

namespace App\Models\BackEnd\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Config;
class UserModel
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
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "mef_user_name";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
//        DB::select(DB::raw("Call get_split_role()"));
//        $listDb = DB::table('v_get_unit as vgu')
//            ->join('tem_split as ts','vgu.mef_user_id', '=', 'ts.id')
//            ->join('mef_role as mr','ts.split', '=', 'mr.id')
//            ->select(
//                 'mr.role'
//                ,'vgu.moef_role_id'
//                ,'vgu.mef_full_name'
//                ,'vgu.mef_user_id as id'
//                ,'vgu.mef_user_name'
//                ,'vgu.mef_position_name'
//                ,'vgu.ministry_name'
//                ,'vgu.secretariat_name'
//                ,'vgu.department_name'
//                ,'vgu.office_name'
//                ,'vgu.avatar'
//                ,'vgu.email'
//                ,'vgu.active'
//            )
//            ->WhereNotNull('vgu.mef_user_id')
//            ->WhereNotNull('ts.split')
//            ->orderBy('mef_order_position_id','DESC');

        $listDb = DB::table('v_get_unit')
            ->select(
                'role'
                ,'moef_role_id'
                ,'mef_full_name'
                ,'mef_user_id as id'
                ,'mef_user_name'
                ,'mef_position_name'
                ,'ministry_name'
                ,'secretariat_name'
                ,'department_name'
                ,'office_name'
                ,'avatar'
                ,'email'
                ,'active'
            )
            ->WhereNotNull('mef_user_id')
            ->orderBy('mef_order_position_id','DESC');
        $total = count($listDb->get());
        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'moef_role_id':
                        $listDb = $listDb->where('moef_role_id','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'mef_full_name':
                        $listDb = $listDb->where('mef_full_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'mef_user_name':
                        $listDb = $listDb->where('mef_user_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'mef_position_name':
                        $listDb = $listDb->where('mef_position_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'ministry_name':
                        $listDb = $listDb->where('ministry_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'secretariat_name':
                        $listDb = $listDb->where('secretariat_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'department_name':
                        $listDb = $listDb->where('department_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'mef_general_department_id':
                        $listDb = $listDb->where('mef_general_department_id','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'office_name':
                        $listDb = $listDb->where('office_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'email':
                        $listDb = $listDb->where('email','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'active':
                        $active = $arrFilterValue == $this->constant['active'] ? 1:0;
                        $listDb = $listDb->where('mef_full_name',$active);
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
//        dd($listDb);
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                'role'                 =>$row->role,
                'moef_role_id'         =>$row->moef_role_id,
                'mef_full_name'        =>$row->mef_full_name,
                'id'                   =>$row->id,
                'mef_user_name'        =>$row->mef_user_name,
                'mef_position_name'    =>$row->mef_position_name,
                'ministry_name'        =>$row->ministry_name,
                'secretariat_name'     =>$row->secretariat_name,
                'department_name'      =>$row->department_name,
                'office_name'          =>$row->office_name,
                'avatar'               =>$row->avatar,
                'email'                =>$row->email,
                'active'               =>$row->active
            );
        }
//        DB::select(DB::raw("Drop Table tem_split"));
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    public function isRoleHasUser($id){
        if(DB::table($this->table['MEF_USER'])->where('moef_role_id',$id)->count() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    public function postNew($id){
        $user = $this->getDataByRowId($id);
        $arrListGeneralDepartment = $this->getAllGeneralDepartment();
        return array(
            'user'					=> $user,
            'listGeneralDepartment'	=> $arrListGeneralDepartment
        );
    }
    public function getAllActiveRole(){
        $listRole = DB::table($this->table['MEF_ROLE'])
            ->select('id','role')
            ->where('active',1)
            ->orderBy('role', 'ASC')
            ->get();
        $arrListRole = array(array("text"=>"", "value" => ""));
        foreach($listRole as $row){
            $arrListRole[] = array(
                'text' 	=> $row->role,
                "value" => $row->id
            );
        }
        return json_encode($arrListRole);
    }
    private function getAllGeneralDepartment(){
        $arrList = DB::table('mef_secretariat')
            ->select('Id','Name')
            ->orderBy('Name', 'ASC')
            ->get();
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
        $arrList = DB::table('mef_department')
            ->select('Id','Name')
            ->where('mef_secretariat_id',$mef_secretariat_id)
            ->orderBy('Name', 'ASC')
            ->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
    public function getOfficerByDepartmentId($department_id){
        $arrList = DB::table('mef_officer AS of')
            ->leftJoin('mef_service_status_information AS status','status.MEF_OFFICER_ID','=','of.Id')
            ->where('status.CURRENT_DEPARTMENT',$department_id)
            ->where('of.is_register',2)//2=Approved
            ->select(
                'of.Id AS officer_id',
                'of.user_name',
                'status.CURRENT_DEPARTMENT AS department_id'
            )
            ->orderBy('of.user_name','ASC')
            ->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->user_name,
                "value" =>$row->officer_id
            );
        }
        return $arr;
    }
    public function postSave($data){
        $id = intval($data['Id']);
        $obj_officer = DB::table('v_get_unit')->Where('mef_officer_id','=',$data['officer_id'])->get();
        //print_r($data);
        if($data['Id'] == 0){
            /* Check user taken */
            $msg = $this->cheekUserName($data['officer_id'],$data['officer_name']);
            //print_r($msg);
            if ($msg['success'] == true){
                return json_encode(array("code" => 0, "message" => trans('users.user_token'), "data" => ""));
            }
            /* Save data */
            $array = array(
                'user_name'                     =>isset($data['officer_name'])? $data['officer_name']:$obj_officer[0]->mef_office_name,
                'password'						=>isset($data['password']) ? str_replace("$2y$", "$2a$", bcrypt($data['password'])):$obj_officer[0]->password,
                'salt' 							=>'',
                'last_login_date' 				=>date('Y-m-d H:i:s'),
                'moef_role_id' 					=>$data['role'],
                'mef_ministry_id' 	            =>isset($data['password']) ? $data['ministry_id']:$obj_officer[0]->ministry_id,
                'mef_general_department_id' 	=>isset($data['password']) ? $data['secretary_id']:$obj_officer[0]->secretariat_id,
                'mef_department_id' 			=>isset($data['password']) ? $data['department_id']:$obj_officer[0]->department_id,
                'mef_office_id' 			    =>isset($data['password']) ? $data['office_id']:$obj_officer[0]->office_id,
                'mef_officer_id'                =>isset($data['password']) ? '':$obj_officer[0]->mef_officer_id,
                'mef_position'                  =>$data['position_name'],
                'mef_member_id'                 =>$data['user_id'],
                'active'						=>$data['active']
            );
            DB::table($this->table['MEF_USER'])->insert($array);
            /* End Save data */
        }else{
            $array = array(
                'user_name'                     =>$obj_officer[0]->mef_office_name,
                'last_login_date' 				=>date('Y-m-d H:i:s'),
                'moef_role_id' 					=>$data['role'],
                'mef_ministry_id' 	            =>$obj_officer[0]->ministry_id,
                'mef_general_department_id' 	=>$obj_officer[0]->secretariat_id,
                'mef_department_id' 			=>$obj_officer[0]->department_id,
                'mef_office_id' 			    =>$obj_officer[0]->office_id,
                'mef_officer_id'                =>$obj_officer[0]->mef_officer_id,
                'mef_position'                  =>$data['position_name'],
                'mef_member_id'                 =>$data['user_id'],
                'active'						=>$data['active']
            );
            DB::table($this->table['MEF_USER'])
                ->where('id', $data['Id'])
                ->update($array);
        }
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
    public function postDelete($listId){
        $countDeleted = 0;
        foreach ($listId as $id){
            $boolean = $this->isCurrentUser($id);
            if($boolean == 1){
                $countDeleted++;
            }else{
                DB::table($this->table['MEF_USER'])->where('id',$id)->delete();
            }
        }
        if($countDeleted >= 1 && count($listId) > 1){
            return array("code" => 0, "message" => $this->constant['itemsDeleted']);
        }else if($countDeleted == 1 && count($listId) == 1){
            return array("code" => 1, "message" => trans('trans.itemInUsed'));
        }else{
            return array("code" => 2,"message" => trans('trans.success'));
        }
    }
    public function isCurrentUser($id){
        $sessionUserId = Session::get('sessionUser')->id;
        return $sessionUserId == $id ? 1:0;
    }
    public function getDataByRowId($id){
        return DB::table($this->table['MEF_USER'])->where('id', $id)->first();
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

        if($cheek){
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
    public function getListRole(){
        $obj =  DB::table('mef_role')
            ->select(
                'id AS value',
                'role AS text')
            ->orderBy('Id','ASC')
            ->get();
        return $obj;
    }

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

}
?>