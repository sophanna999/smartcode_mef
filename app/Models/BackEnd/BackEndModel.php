<?php

namespace App\Models\BackEnd;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Model;
class BackEndModel extends Model
{
	public $member=null;
    public function __construct()
    {
		$this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
		$this->member = explode(',',$this->userSession->mef_member_id);
		array_push($this->member,$this->userSession->id);
    }
	public function getApprovePersonalInfo($officer_id)
	{
		return $db = DB::table('v_mef_officer')
		// ->where('mef_officer_id_approve',$officer_id)
		->where('Id',$officer_id)
		->whereNull('approve')
		// ->where('is_approve',2)
		->where('active',1)
		->orderBy('user_modify_date','DESC')->first();
	}
	public function getAllGeneralDepartments($min_id=''){
        $arrList = DB::table('mef_secretariat')
			->select('Name as text'
				,'Id as value'
			);
		if($min_id !== ''){
			$arrList =$arrList->where('mef_ministry_id',$min_id);
		}
			
		$arrList =$arrList->orderBy('Name', 'DESC')->get();
		return $arrList;
    }
	public function getAllDepartmentBySecretariatsId($mef_secretariat_id,$id=''){
        $arrList = DB::table('mef_department')->where('mef_secretariat_id',$mef_secretariat_id)
			->select('Name as text'
				,'Id as value'
			)->OrderBy('Name', 'ASC');
        if($id!=''){
            $arrList=$arrList->where('id',$id);
        }
        $arrList=$arrList->get();
		return $arrList;
    }
	public function getOfficeByDepartmentsId($departmentId,$is_null=''){
        $arrList = DB::table('mef_office')->where('mef_department_id',$departmentId)
			->select('Name as text'
				,'Id as value'
			)->orderBy('Id', 'DESC')->get();
		if($is_null==''){
			return $arrList;
		}
			// return $arrList;
        return $arrList = array_merge(array(array("text"=>"", "value" => "")),$arrList);
    }
	public function getPositions($value='',$is_null='')
	{
		$arrList = DB::table('mef_position')->select('Name as text'
				,'Id as value'
			)->orderBy('ORDER_NUMBER', 'ASC')->get();
        
        if($is_null==''){
			return $arrList;
		}
			
        return $arrList = array_merge(array(array("text"=>"", "value" => "")),$arrList);
	}
	public function getAllOfficer($min=null,$gend=null,$dep=null,$off=null,$return=true)
	{
		if($min==null){
			$min= $this->userSession->mef_ministry_id;
		}if($gend==null){
			$gend= $this->userSession->mef_general_department_id;
		}if($dep==null){
			$dep= $this->userSession->mef_department_id;
		}if($off==null){
			// $off= $this->userSession->mef_office_id;
		}
		$list_type = DB::table('v_mef_officer')
		->select('full_name_kh as text','Id as value','position')
		->where('general_department_id',$gend)
		// ->where('is_approve',2)
		->where('active',1)
		->whereNull('approve');
		if($dep!=null && $dep!='NA'){
			$list_type = $list_type->where('department_id',$dep);
		}
		if($off!=null && $off!='NA'){
			$list_type = $list_type->where('office_id',$off);
		}
		$list_type = $list_type->orderBy('position_order', 'orderNumber','desc');
		if($return==true){
			$list_type = $list_type->get();
			return array_merge(array((object) array("text"=>"", "value" => "","position"=>"")),$list_type);
		}
		return $list_type;
		
	}
	public function getAllMissionType($min=null,$gend=null,$dep=null,$off=null,$return=true)
	{
		if($min==null){
			$min= $this->userSession->mef_ministry_id;
		}if($gend==null){
			$gend= $this->userSession->mef_general_department_id;
		}if($dep==null){
			$dep= $this->userSession->mef_department_id;
		}if($off==null){
			$off= $this->userSession->mef_office_id;
		}
		$list_type =DB::table('mef_mission_type')
			->select('name as text','id as value');
		if($min!=null && $min!='NA'){
			$list_type = $list_type->where('mef_ministry_id',$min);
		}
		if($gend!=null && $gend!='NA'){
			$list_type = $list_type->where('mef_general_department_id',$gend);
		}
		if($dep!=null && $dep!='NA'){
			$list_type = $list_type->where('mef_department_id',$dep);
		}
		if($off!=null && $off!='NA'){
			// $list_type = $list_type->where('mef_office_id',$off);
		}
		$list_type = $list_type->orderBy('order_number','ASC');
		if($return==true){
			$list_type = $list_type->get();
			if($list_type){
				return $list_type;
			}
			// return array_merge(array((object) array("text"=>"", "value" => "")),$list_type);
			return array((object) array("text"=>"", "value" => ""));
		}
		return $list_type;
	}
	public function checkTakeLeave($officer_Id,$where=array())
	{
		$take_dt = DB::table('mef_take_leave')
			->select(DB::raw("SUM(day) as total_day"))
			->where('officer_Id',$officer_Id);
		if(!empty($where)){
			$take_dt = $take_dt->where($where);
		}
		$take_dt =$take_dt->first();
		return isset($take_dt->total_day)?$take_dt->total_day:0;
	}
	public function getTakeRoleType($id=null){
		$lst_db = DB::table('mef_take_leave_role_type');
		if($id!=null){
			return $lst_db =$lst_db->where('Id',$id)->first();
		}
		return $lst_db =$lst_db->get();
	}
}

