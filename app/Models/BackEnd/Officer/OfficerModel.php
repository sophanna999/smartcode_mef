<?php

namespace App\Models\BackEnd\Officer;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Excel;

class OfficerModel
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
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "register_date";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

        $this_role = $dataRequest['this_role_id'];
        $this_depart = $dataRequest['this_department_id'];

        if($this_role != 1){
            $listDb = DB::table('v_get_all_mef_officer')
                ->select(
                    'Id',
                    'full_name_en',
                    'full_name_kh',
                    'avatar',
                    'email',
                    'phone_number_1',
                    'general_department_name',
                    'department_name',
                    //'is_register',
                    DB::raw("CONVERT(is_register USING utf8) COLLATE utf8_general_ci as is_register"),
                    'register_date',
                    'positionName',
                    'orderNumber',
                    'isCount'
                )
                ->where('department_id',$dataRequest['this_department_id']);
        }elseif($this_role == 1){
            $listDb = DB::table('v_get_all_mef_officer')
                ->select(
                    'Id',
                    'full_name_en',
                    'full_name_kh',
                    'avatar',
                    'email',
                    'phone_number_1',
                    'general_department_name',
                    'department_name',
                    //'is_register',
                    DB::raw("CONVERT(is_register USING utf8) COLLATE utf8_general_ci as is_register"),
                    'register_date',
                    'positionName',
                    'orderNumber',
                    'isCount'
                );
        }
 



        $total = count($listDb->get());
        if($filtersCount>0){			
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
				 $arrFilterValue = strval($arrFilterValue);
                switch($arrFilterName){
					case 'full_name_en':
							$listDb = $listDb->where('full_name_en','LIKE','%'.$arrFilterValue.'%');
						break;
					case 'full_name_kh':
							$listDb = $listDb->where('full_name_kh','LIKE','%'.$arrFilterValue.'%');
						break;
                    case 'email':
                        $listDb = $listDb->where('email','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'phone_number_1':
                        $listDb = $listDb->where('phone_number_1','LIKE','%'.$arrFilterValue.'%');
                        break;
						case 'general_department_name':
							$listDb = $listDb->where('general_department_name','LIKE','%'.$arrFilterValue.'%');
						break;
						case 'department_name':
							$listDb = $listDb->where('department_name','LIKE','%'.$arrFilterValue.'%');
						break;
					case 'is_register':
							//$listDb = $listDb->where('is_register',$arrFilterValue);
                        $listDb = $listDb->where(DB::raw("CONVERT(is_register USING utf8) COLLATE utf8_general_ci"),$arrFilterValue);
						break;
                    case 'is_approve':
                        $listDb = $listDb->where('is_approve',$arrFilterValue);
                        break;
                    case 'register_date':
                        $arrFilterValue = \DateTime::createFromFormat('d/m/Y g:i A', $arrFilterValue)->format('Y-m-d');
                        $listDb = $listDb->where('register_date','LIKE','%'.$arrFilterValue.'%');
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
				"Id"           				=>$row->Id,
				"full_name_kh"  			=>$row->full_name_kh,
				"full_name_en"  			=>$row->full_name_en,
				"avatar"  					=>$row->avatar,
				"email"						=>$row->email,
                "phone_number_1"       		=>$row->phone_number_1,
				"is_register"				=>$row->is_register,
				"department_name"			=>$row->department_name,
				"general_department_name"	=>$row->general_department_name,
				"register_date"				=>$row->register_date,
				"positionName"				=>$row->positionName,
				"orderNumber"				=>$row->orderNumber,
				"isCount"					=>$row->isCount
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list,"dataForm" => $dataRequest));
    }
	public function getOfficerRegisterStatus(){
		$array = array(
		    $this->constant['registered'],
            $this->constant['completed'],
            $this->constant['approved'],
            $this->constant['waitingApproval']
        );
		return json_encode($array);
	}
	public function getOfficerSubmitForm($officerId){
		
		$arrayList	=	array(
			"personalInfo" => 0,
			"situationPublicInfo" => 0,
			"workingHistroy" => 0,
			"awardSanction" => 0,
			"generalKnowledge" => 0,
			"abilityForeignLanguage" => 0,
			"familySituations" => 0
		);
		// personalInfo
		$mefPersonalInformation	= DB::table('mef_personal_information')->where('MEF_OFFICER_ID',$officerId)->first();
		if($mefPersonalInformation != null){
			$arrayList["personalInfo"]	=	$mefPersonalInformation->IS_REGISTER;
		}
		// situationPublicInfo
		$mefServiceStatusInformation = DB::table('mef_service_status_information')->where('MEF_OFFICER_ID', $officerId)->first();
		if($mefServiceStatusInformation != null){
			$arrayList["situationPublicInfo"]	=	$mefServiceStatusInformation->IS_REGISTER;
		}
		// workingHistroy
		$workingHistroy = DB::table('mef_work_history')
			->where('MEF_OFFICER_ID', $officerId)->orderBy('ID', 'asc')
			->first();
		if($workingHistroy != null){
			$arrayList["workingHistroy"]	=	$workingHistroy->IS_REGISTER;
		}
		// awardSanction
		$awardSanctionType1 = DB::table('mef_appreciation_awards')
			->where('MEF_OFFICER_ID', $officerId)->where('AWARD_TYPE',1)
			->first();
		if($awardSanctionType1 != null){
			$arrayList["awardSanction"]	=	$awardSanctionType1->IS_REGISTER;
		}		
		// generalKnowledge
		$generalKnowledge = DB::table('mef_general_qualifications')
			->where('MEF_OFFICER_ID', $officerId)
			->first();
		if($generalKnowledge != null){
			$arrayList["generalKnowledge"]	=	$generalKnowledge->IS_REGISTER;
		}		
		// abilityForeignLanguage
		$abilityForeignLanguage = DB::table('mef_foreign_languages')
			->where('MEF_OFFICER_ID', $officerId)
			->first();
		if($abilityForeignLanguage != null){
			$arrayList["abilityForeignLanguage"]	=	$abilityForeignLanguage->IS_REGISTER;
		}	
		// familySituations
		$familySituations = DB::table('mef_family_status')
			->where('MEF_OFFICER_ID', $officerId)
			->first();
		if($familySituations != null){
			$arrayList["familySituations"]	=	$familySituations->IS_REGISTER;
		}
		return $arrayList;
	}
	public function postSave($data){
		$userModifyId = empty(Session::get('sessionUser')->id) ? '' :Session::get('sessionUser')->id;
		$id = intval($data['Id']);
		if ($userModifyId != '') {
			DB::select(DB::raw('Call do_approve(' . $id . ',' . $userModifyId . ', @result)'));
			$boolean = DB::select(DB::raw('Select @result as result'));
			//dd($boolean[0]->result);
		}
		if ($boolean[0]->result == 1){
            return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
        }else{
            return json_encode(array("code" => 0, "message" => "Invalid officer id", "data" => ""));
        }
	}
	public function saveIsCount($id,$isCount){
		DB::table('mef_officer')
				->where('Id', $id)
				->update([
					'isCount'	=>$isCount
				]);
		return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
	}
	public function savePositionId($data){
		DB::table('mef_service_status_information')
				->where('MEF_OFFICER_ID', $data['Id'])
				->update([
					'CURRENT_POSITION'	=>$data['CURRENT_POSITION']
				]);
		DB::table('mef_personal_information')
				->where('MEF_OFFICER_ID', $data['Id'])
				->update([
					'orderNumber'	=>$data['oderNumber']
				]);
		DB::table('mef_officer')
				->where('Id', $data['Id'])
				->update([
					'active'	=>isset($data['active'])
				]);
		return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
	}
	public function saveNotification($data){
		$array = array(
			'FROM_USER_ID' => $this->userSession->id,
			'TO_USER_ID'   => $data['Id'],
			'TITLE'		   => "កែតម្រូវ បំពេញបន្ថែម",
			'COMMENT'	   => $data['COMMENT'],
			'METHOD_TYPE'  => "1",
			"CREATED_DATE" => date("Y-m-d H:i:s"),
		);
		DB::table('mef_notification')->insert($array);
		//return array("code" =>1,"message" => $this->constant['success']);	
	}
	public function postDelete($id){
		// dd($id);
	    $id = intval($id);
        $userRec = $this->getDataPeersionalById($id);
        // dd($userRec);
        if($userRec->AVATAR != ''){
            if(Storage::disk('public')->exists($userRec->AVATAR)){
                Storage::disk('public')->delete($userRec->AVATAR);
            }
        }
        DB::table('mef_officer')->where('Id',$id)->delete();
        DB::table('mef_personal_information')->where('MEF_OFFICER_ID',$id)->delete();
		DB::table('mef_officer_current_address')->where('mef_officer_id',$id)->delete();
		DB::table('mef_appreciation_awards')->where('MEF_OFFICER_ID',$id)->delete();
        DB::table('mef_family_status')->where('MEF_OFFICER_ID',$id)->delete();
        DB::table('mef_service_status_information')->where('MEF_OFFICER_ID',$id)->delete();
        DB::table('mef_situation_outside_framwork')->where('MEF_OFFICER_ID',$id)->delete();
        DB::table('mef_situation_outside_framwork_free')->where('MEF_OFFICER_ID',$id)->delete();
        DB::table('mef_working_history_private')->where('MEF_OFFICER_ID',$id)->delete();
        DB::table('mef_work_history')->where('MEF_OFFICER_ID',$id)->delete();
        DB::table('mef_appreciation_awards')->where('MEF_OFFICER_ID',$id)->delete();
        $MEF_OFFICER_ID = DB::table('mef_family_status')->select('ID')->where('MEF_OFFICER_ID', $id)->first();
         if(count($MEF_OFFICER_ID) > 0) {
            DB::table('mef_relatives_information')->where('FAMILY_STATUS_ID',$MEF_OFFICER_ID->ID )->delete();
            DB::table('mef_childrens')->where('FAMILY_STATUS_ID', $MEF_OFFICER_ID->ID)->delete();
         }
        return array("code" => 1,"message" => trans('trans.success'));	
	}
	public function getDataPeersionalById($id){
        return DB::table('mef_personal_information')->where('MEF_OFFICER_ID', $id)->first();
    }
    public function getDataAllGridDate($id){
        return DB::table('v_get_all_mef_officer')->where('Id', $id)->first();
    }
    public function getPosition()
    {
        $data = DB::table('mef_position')->get();
        $arr = array(array("text" => "", "value" => ""));
        foreach ($data as $row) {
            $arr[] = array(
                'text' => $row->NAME,
                "value" => $row->ID
            );
        }
        return $arr;
    }
	public function getDataByRowId($Id){
		$sql = DB::table('v_mef_officer')
                ->select(
                    'Id',
                    'full_name_kh AS FULL_NAME_KH',
                    'full_name_en AS FULL_NAME_EN',
                    'place_of_birth AS PLACE_OF_BIRTH',
                    'current_address AS CURRENT_ADDRESS',
                    'email AS EMAIL',
                    'date_of_birth',
                    'avatar AS AVATAR',
                    'phone_number_1 AS PHONE_NUMBER_1',
                    'general_department_name AS SecretariatName'
                )
                ->where('Id',$Id)
                ->first();
		if($sql != null){
			return $sql;
		}else{
		    return array();
        }
	}
	public function getDataApproveByRowId($Id){
		$sql = DB::select(DB::raw("Select Id From mef_officer mf Where mef_officer_id_approve In ($Id) and is_register In (2) Order by user_modify_date DESC limit 1"));
		if($sql != null){
			return $sql;
		}else{
			return array();
		}
	}
	public function getApprovedDateThisUser($id){
		$row = DB::table('mef_officer')->where('Id', $id)->first();
		if($row != null){
			return $row->approval_date;
		}
	}
	public function getPersonalInfByOfficerId($id){
		$row = DB::table('mef_personal_information')->where('MEF_OFFICER_ID', $id)->first();
		if($row != null){
			return $row;
		}
	}
	private function getCurrentAdrress($mef_officer_id){
		$row = DB::table('mef_officer_current_address')->where('mef_officer_id', $mef_officer_id)->first();
		if($row != null){
			return $row;
		}
	}
	public function getSeviceStatusInfByOfficerId($id){

		$row = DB::table('v_service_status_info')->where('MEF_OFFICER_ID', $id)->first();

		if($row != null){
			return $row;
		}else{
			return $row = array();
		}
	}
	public function getOfficerCurrentAddress($id){
		$data = DB::table('v_current_address')->where('mef_officer_id',$id)->first();
		if($data != null){
			return $data;
		}else{
			return $data = array();
		}
	} 
	public function getSeviceStatusCurrentByOfficerId($id){

		$row = DB::table('v_service_status_current')->where('MEF_OFFICER_ID', $id)->first();
		// dd($row);
		if($row != null){
			return $row;
		}
	}
	public function getSeviceStatusAdditonalByOfficerId($id){
		$row = DB::table('v_service_status_additional')->where('MEF_OFFICER_ID', $id)->first();
		// dd($row);
		if($row != null){
			return $row;
		}
	}
	public function getSituationOutSideFramworkByOfficerId($id){
	 	$row = DB::table('mef_situation_outside_framwork')
	 	->where('MEF_OFFICER_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getSituationOutSideFreeByOfficerId($id){
	 	$row = DB::table('mef_situation_outside_framwork_free')
	 	->where('MEF_OFFICER_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getFamilyStatusByOfficerId($id){
	 	$row = DB::table('mef_family_status')
	 	->where('MEF_OFFICER_ID', $id)
	 	->first();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getWorkingHistoryByOfficerId($id){
	 	$row = DB::table('mef_work_history')
	 	->where('MEF_OFFICER_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getWorkingHistoryPrivateByOfficerId($id){
	 	$row = DB::table('mef_working_history_private')
	 	->where('MEF_OFFICER_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getAppreciationAwardsByOfficerId($id){
	 	$row = DB::table('v_appreciation_award')
	 	->where('MEF_OFFICER_ID', $id)
	 	->where('AWARD_TYPE',1)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getAppreciationSanctionByOfficerId($id){
	 	$row = DB::table('v_appreciation_award')
	 	->where('MEF_OFFICER_ID', $id)
	 	->where('AWARD_TYPE',2)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getGeneralQualificationsByOfficerId($id){
	 	$row = DB::table('v_general_qualification')
	 	->where('MEF_OFFICER_ID', $id)
	 	->where('Q_TYPE',1)
	 	->first();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getGeneralQualificationsSkillByOfficerId($id){
	 	$row = DB::table('v_general_qualification')
	 	->where('MEF_OFFICER_ID', $id)
	 	->where('Q_TYPE',2)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getGeneralQualificationsTrainingOfficerId($id){
	 	$row = DB::table('v_general_qualification')
	 	->where('MEF_OFFICER_ID', $id)
	 	->where('Q_TYPE',3)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getForeignLanguagesOfficerId($id){
	 	$row = DB::table('v_foreign_language')
	 	->where('MEF_OFFICER_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getRelativesInformationOfficerId($id){
	 	$row = DB::table('v_reletative_information')
	 	->where('MEF_OFFICER_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getChildrenOfficerId($id){
	 	$row = DB::table('v_childrens')
	 	->where('MEF_OFFICER_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getPhoneNumber($id){

		$userStatus = DB::table('mef_family_status')
			->where('MEF_OFFICER_ID', $id)
			->get();

		if(count($userStatus) > 0){
			$phone = json_decode($userStatus[0]->SPOUSE_PHONE_NUMBER);
			if(count($phone) > 0){
				return $phone;
			}
			return array();
		}else{
			return array();
		}
	}
	public function getOfficerHistoryById($id){
		$affectedRow = DB::table('mef_officer_history')
			->where('mef_officer_id', $id)
			->orderBy('mef_form_number','ASC')
			->groupBy('mef_form_number')
			->select('mef_form_title','mef_form_number', DB::raw('MAX(last_modified_date) AS last_modified_date'))
			->get();
		if($affectedRow != null){
			return $affectedRow;
		}
	}
	public function getDataPushBack($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "CREATED_DATE";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

        $this_role = $dataRequest['this_role_id'];
        $member_id = explode(',',$dataRequest['mef_member_id']);

        if($this_role != 1){
            //new select notification code
            $listDb = DB::table('mef_notification as noti')
                ->leftjoin('mef_user as u','noti.FROM_USER_ID','=','u.id')
                ->leftjoin('mef_personal_information as per','noti.TO_USER_ID','=','per.ID')
                ->leftjoin('mef_personal_information as persional','noti.FROM_USER_ID','=','persional.ID')
                ->select(
                    'noti.ID as ID',
                    'per.FULL_NAME_KH as TO_USER_ID',
                    'noti.TITLE as TITLE',
                    'noti.COMMENT as COMMENT',
                    'noti.METHOD_TYPE as METHOD_TYPE',
                    'noti.STATUS as STATUS',
                    'noti.CREATED_DATE as CREATED_DATE',
                    'noti.IS_READ as IS_READ',
                    DB::raw('(CASE
                    WHEN (`noti`.`METHOD_TYPE` = 1) THEN `u`.`user_name`
                    ELSE `persional`.`FULL_NAME_KH`
                END) AS `FROM_USER_ID`')
                )
                ->whereIn('noti.FROM_USER_ID',$member_id)
            ;
        }else{
            $listDb = DB::table('v_notofication');
        }


        $total = count($listDb->get());
        $listDb = $listDb
				->orderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "ID"           		=> $row->ID,
                "FROM_USER_ID"   	=> $row->FROM_USER_ID,
                "TO_USER_ID"  		=> $row->TO_USER_ID,
				"TITLE"				=> $row->TITLE,
                "COMMENT"			=> $row->COMMENT,
				"METHOD_TYPE"		=> $row->METHOD_TYPE,
				"STATUS"			=> $row->STATUS,
				"CREATED_DATE"		=> date('d/m/Y h:i:s A',strtotime($row->CREATED_DATE)),
				"IS_READ"			=> $row->IS_READ
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
	public function getOfficer(){
        $arrList = DB::table('mef_personal_information')
        		 ->OrderBy('Id', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->FULL_NAME_KH,
                "value" => $row->MEF_OFFICER_ID
            );
        }
        return json_encode($arr);
    }
    public function saveNewNotification($data){
    	//dd($data);
		$array = array(
			'FROM_USER_ID' => $this->userSession->id,
			'TO_USER_ID'   => $data['officer'],
			'TITLE'		   => "កែតម្រូវ បំពេញបន្ថែម",
			'COMMENT'	   => $data['COMMENT'],
			'METHOD_TYPE'  => "1",
			"CREATED_DATE" => date("Y-m-d H:i:s"),
		);
		DB::table('mef_notification')->insert($array);
		//return array("code" =>1,"message" => $this->constant['success']);	
	}
	public function getnotificationdata($Id){
		// dd($Id);
		return DB::table('mef_notification')->where('ID', $Id)->first();
	}
	public function getAllNotification($id){
		$data = DB::table('v_notofication')->where('officerId',$id)->first();
		if(count($data)){
			return array("code" => 1, "message" => "success", "data" => $data);
		}
	}
	public function getCommand($id){
		$data = DB::table('v_notofication')
					->where('officerId',$id)
					->orderBy('ID','DESC')->first();
		if(count($data)){
			return array("code" => 1, "message" => "success", "data" => $data);
		}else{
            return array("code" => 1, "message" => "success", "data" => '');
        }
	}
	// Report Excel
	public function postExportExcel($dataRequest_form){ 
		$dataRequest = json_decode($dataRequest_form["data_form_export"], true);
		if($dataRequest == null){
			return redirect::back();
		}
		$dataRequest["pagesize"] = $this->constant['maxPagesize'];
		$data_return 	= json_decode($this->getDataGrid($dataRequest));
		$data 			= $data_return->items;
		// Export Excel
		Excel::create('report_mef_all', function($excel) use ($data) {			
			$excel->sheet('excel', function($sheet) use ($data) {
				$data_cell=array();
				foreach ($data as $key => $values) {
					$data_cell[$key]["ល.រ"] = $key + 1;
					$data_cell[$key][trans("officer.full_name")] = $values->full_name_kh;
					$data_cell[$key][trans("officer.english_name")] = $values->full_name_en;
					$data_cell[$key][trans("trans.status")] = $values->is_register;
					$data_cell[$key][trans("officer.register_date")] = date('d/m/Y h:i:s A',strtotime($values->register_date));
					$data_cell[$key][trans("officer.phone_number")] = $values->phone_number_1;
					$data_cell[$key][trans("officer.email")] = $values->email;
					$data_cell[$key][trans("officer.generalDepartment")] = $values->department_name;
					$data_cell[$key][trans("officer.department")] = $values->general_department_name;
				}
				$sheet->fromArray($data_cell);
				$sheet->setFontFamily('Khmer MEF1');
				$countDataPlush1 = count($data) + 1;
				$sheet->setBorder('A1:I'.$countDataPlush1, 'thin');
				$sheet->row(1, function($row) {
					$row->setBackground('#DFF0D8');
				});
				// Add before first row
				$sheet->prependRow(1, array(
					"បញ្ជីមន្រី្តរាជការ"
				));
				$sheet->mergeCells('A1:I1','center');
				$sheet->setHeight(1, 30); 
				$sheet->cell('A1:I1', function($cell) {
					$cell->setFontFamily('Khmer MEF2');
					$cell->setValignment('center');
				});
				$sheet->cell('A2:A'.($countDataPlush1 +1 ), function($cell) {
					$cell->setAlignment('center');
				});
			});
			$excel->getActiveSheet()->getStyle('A1:I'.$excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		})->export('xls');
    }
    public function getOfficerUserName($id){
        $query = DB::table('mef_officer')
                ->select('user_name')
                ->where('Id',$id)
                ->first();
        return $query;
    }
    public function updateOfficerPassword($data = array(),$officer_id){
        $affected = DB::table('mef_officer')
                    ->where('Id', $officer_id)
                    ->update($data);
        if ($affected == true){
            return true;
        }else{
            return false;
        }
    }
    public function getTotalOfficerView($mef_general_department_id,$mef_department_id,$office_id,$mef_position_id,$class_rank_id,$from_dob,$to_dob){
        $affected_row = DB::table('v_mef_officer_report')
            ->select(DB::raw('count(*) as total_officer'))
            ->where(function($query) use ($mef_general_department_id,$mef_department_id,$office_id,$mef_position_id,$class_rank_id,$from_dob,$to_dob){
                if ($mef_general_department_id != '') {
                    $query->where('general_department_id',$mef_general_department_id);
                }
                if ($mef_department_id != '') {
                    $query->where('department_id',$mef_department_id);
                }
                if ($office_id != '') {
                    $query->where('office_id',$office_id);
                }
                if ($mef_position_id != '') {
                    $query->where('position_id',$mef_position_id);
                }
                if ($class_rank_id != '') {
                    $query->where('class_rank_id',$class_rank_id);
                }
//                if ($from_dob != '' & $to_dob = '') {
//                    $query->whereBetween('date_of_birth',array($from_dob,$to_dob));
//                }
            })
            ->first();
        return $affected_row->total_officer;
    }
	public function auditLogForm($id,$arrTbl,$approval_date,$table_type = null){
		$auditLog = DB::table('mef_audit_log')
			->whereIn('table_name',$arrTbl)
			->where('user_modify', $id)
			->where('log_type','Update')
			->where('date_midify','>',date("Y-m-d H:i:s",strtotime($approval_date)));
		if($table_type != null){
			$auditLog = $auditLog->where('table_type', $table_type);
		}	
		$auditLog = $auditLog->orderBy('date_midify', 'desc')->get();
		$result = array();
		foreach ($auditLog as $data) {
		  $field_name = $data->field_name;
		  if (isset($result[$field_name])) {
			 $result[$field_name][] = $data;
		  } else {
			 $result[$field_name] = array($data);
		  }
		}
		return $result;	
	}
	public function countStatusOfficer(){
		// 0=register, 1=submit, 2=complete, 3=waitingApproval
		$affected_row = DB::select(DB::raw("Select 'register' as type, count(*) as num From mef_officer mf Where IFNULL(is_register,0)=0 and (ifnull(mf.approve,'') = '')
                                                             union all
                                                             Select 'submit' as type, count(*) as num From mef_officer mf Where IFNULL(is_register,0)=1 and (ifnull(mf.approve,'') = '')
                                                             union all
                                                             Select 'complete' as type, count(*) as num From mef_officer mf Where IFNULL(is_register,0)=2 and (ifnull(mf.approve,'') = '')
                                                             union all
                                                             Select 'waitingApproval' as type, count(*) as num From mef_officer mf Where IFNULL(is_register,0)=3 and (ifnull(mf.approve,'') = '')"));
		if (count($affected_row)){
		    $total= $affected_row;
        }
		return $total;
	}
	public function auditLogFormTableMore($id,$arrTbl,$approval_date,$table_type = null){
		$auditLog = DB::table('mef_audit_log')
			->whereIn('table_name',$arrTbl)
			->where('user_modify', $id)
			->where('log_type', 'Delete')
			->where('date_midify','>',date("Y-m-d H:i:s",strtotime($approval_date)));
		if($table_type != null){
			$auditLog = $auditLog->where('table_type', $table_type);
		}	
		$auditLog = $auditLog->orderBy('date_midify', 'desc')->get();
		$result = array();
		foreach ($auditLog as $data) {
		  $date_midify = $data->date_midify;
		  if (isset($result[$date_midify])) {
			 $result[$date_midify][] = $data;
		  } else {
			 $result[$date_midify] = array($data);
		  }
		}
		$resultTree = array();
		foreach($result as $key=>$data){
			$resultTree[$key] = $this->buildTree($data);
		}
		return $resultTree;	
	}
	public function buildTree($auditLog, $field_name = null) {
        $result = array();
		foreach ($auditLog as $data) {
		  $field_name = $data->field_name;
		  if (isset($result[$field_name])) {
			 $result[$field_name][] = $data;
		  } else {
			 $result[$field_name] = array($data);
		  }
		}
		return $result;	
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
	public function getMyProfile($officer_id){
		$array = array(
			'avatar'                    =>'',
			'full_name_kh'              =>'',
			'position'                  =>'',
			'department_name'           =>'',
			'general_department_name'   =>''
		);
		$list = DB::table('v_mef_officer')
			->where('Id',$officer_id)
			->select('full_name_kh','position','department_name','general_department_name','avatar')
			->first();
		if (count($list)){
			$array = $list;
		}
		return (object)$array;
	}
}
?>