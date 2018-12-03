<?php
namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Redirect;
use App\Validation\ValidationAuth;
use Illuminate\Support\Facades\Request;

class UpdateInfoModel{
	protected $table = 'mef_officer_profile_transfer';
	
	public function getListOfficerTransfer(){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$query = DB::select('select pro_tran.ID as no_id,
					info.MEF_OFFICER_ID AS Id, AVATAR as avatar,info.FULL_NAME_KH,info.FULL_NAME_EN,
					info.PLACE_OF_BIRTH,info.CURRENT_ADDRESS,info.PHONE_NUMBER_1,info.EMAIL,
						(CASE 
							 WHEN pro_tran.status = 1 THEN "មិនបានទទួល"
							 ELSE "បានទទួល"
						END) AS is_status
						from mef_personal_information AS info
						right join mef_officer_profile_transfer AS pro_tran
						ON pro_tran.to_officer_id = info.Id
						WHERE pro_tran.from_officer_id="'.$userId.'"
						AND pro_tran.status=1
						ORDER BY pro_tran.updated_at asc');
		if($query != null){
			return $query;
		} else {
			return array();
		}
		
	}
	public function postAccTransfer($data){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$array = array(
			'TITLE'				=>'ទាញយកប្រវត្តរូប',
			'COMMENT'			=>'ជ្រើសរើសយកគំរូព័ត៌មាន និងកែប្រែទិន្នន័យ',
			'TO_USER_ID'		=>$data,
			'CREATED_DATE'		=>date('Y-m-d h:i:s'),
			'FROM_USER_ID'		=>$userId,
			'METHOD_TYPE'		=>2
		);
		$officer_id = DB::table('mef_notification')->insertGetId($array);
	}
	
	public function getAllNotification(){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$allNotification = DB::select('SELECT  `STATUS`,`COMMENT`,`METHOD_TYPE`,`CREATED_DATE`,`TITLE`,`FROM_USER_ID`,
							(CASE 
								WHEN mef_not.`IS_READ` = 1 THEN "មិនបានទទួល"
									 ELSE "បានទទួល"
							END) AS IS_READ,                            
                            (CASE 
                             	WHEN mef_not.`METHOD_TYPE` = 1                              
                             		THEN (SELECT user_name FROM mef_user                                           
                                          AS mef_per WHERE                                           
                                          mef_per.id=mef_not.`FROM_USER_ID`)                              
                            		ELSE 
											(SELECT FULL_NAME_KH FROM mef_personal_information                                           
                                          AS mef_per WHERE                                           
                                          mef_per.MEF_OFFICER_ID=mef_not.`FROM_USER_ID`)                              
                             END) AS `FROM_USER`				
                            FROM `mef_notification` AS mef_not
							WHERE mef_not.TO_USER_ID="'.$userId.'"
							ORDER BY mef_not.`CREATED_DATE` DESC
							');
		if($allNotification != null){
			return $allNotification;
		} else {
			return array();
		}
	}
	
	public function getNewNotification($editId=null){
		$userId = empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id;
		$allNotification = DB::table('mef_notification')
			->where('STATUS',1)->where('TO_USER_ID',$userId)->where('IS_READ',0)
			->orderBy('ID', 'desc')
			->get();
		if($allNotification != null){
			return $allNotification;
		} else {
			return array();
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
	
	public function getSMSbyId($id){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$notification = DB::table('mef_notification')
			->where('STATUS',1)->where('TO_USER_ID',$userId)->where('ID',$id)
			->get();
		return $notification;
	}

	public function getListPersional(){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$query = DB::table('mef_personal_information')
				 ->where('MEF_OFFICER_ID',$userId)
				 // ->where('IS_REGISTER',1)
				->first();

		if($query != null){
			return $query;
		} else {
			return array();
		}
		
	}

	public function postInsertPersonalInfo($data){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		//dd($data);
		$array = array(
			'PERSONAL_INFORMATION'		=>isset($data['PERSONAL_INFORMATION']) ? $data['PERSONAL_INFORMATION']:'',
			'OFFICIAL_ID'				=>isset($data['OFFICIAL_ID']) ? $data['OFFICIAL_ID']:'',
			'UNIT_CODE'					=>isset($data['UNIT_CODE']) ? $data['UNIT_CODE']:'',
			'FULL_NAME_KH'				=>isset($data['FULL_NAME_KH']) ? $data['FULL_NAME_KH']:'',
			'FULL_NAME_EN'				=>isset($data['FULL_NAME_EN']) ? $data['FULL_NAME_EN']:'',
			'PASSPORT_ID_EXPIRED_DATE'	=>isset($data['PASSPORT_ID_EXPIRED_DATE']) ? $data['PASSPORT_ID_EXPIRED_DATE']:'',
			'DATE_OF_BIRTH'				=>isset($data['DATE_OF_BIRTH']) ? $data['DATE_OF_BIRTH']:'',
			'NATION_ID_EXPIRED_DATE'	=>isset($data['NATION_ID_EXPIRED_DATE']) ? $data['NATION_ID_EXPIRED_DATE']:'',
			'GENDER'					=>isset($data['GENDER']) ? $data['GENDER']:'ប្រុស' ,
			'PASSPORT_ID'				=>isset($data['PASSPORT_ID']) ? $data['PASSPORT_ID']:'',
			'NATION_ID'					=>isset($data['NATION_ID']) ? $data['NATION_ID']:'',
			'PHONE_NUMBER_1'			=>isset($data['PHONE_NUMBER_1']) ? $data['PHONE_NUMBER_1']:'',
			'PHONE_NUMBER_2'			=>isset($data['PHONE_NUMBER_2']) ? $data['PHONE_NUMBER_2']:'',
			'EMAIL'						=>isset($data['EMAIL']) ? $data['EMAIL']:'',
			'CURRENT_ADDRESS'			=>isset($data['CURRENT_ADDRESS']) ? $data['CURRENT_ADDRESS']:'',
			'PLACE_OF_BIRTH'			=>isset($data['PLACE_OF_BIRTH']) ? $data['PLACE_OF_BIRTH']:'',
			'NATIONALITY_1'				=>isset($data['NATIONALITY_1']) ? $data['NATIONALITY_1']:'',
			'NATIONALITY_2'				=>isset($data['NATIONALITY_2']) ? $data['NATIONALITY_2']:'',
			'MARRIED'					=>isset($data['MARRIED']) ? $data['MARRIED']:'',
			'AVATAR'					=>isset($data['AVATAR']) ? $data['AVATAR']:'',
			'IS_REGISTER'				=>intval(0)
			
		);
		//dd($userId);
		 return $affectedRow = DB::table('mef_personal_information')
		 		->where('MEF_OFFICER_ID', $userId)
		 		->update($array);
		 // return json_encode(array('code'=>1,'message'=>'ព័ត៌មានផ្ទាល់ខ្លួនត្រូវបានរក្សាទុក', "description" => ""));
	}

	public function getServiceStatusFromOfficer($id){
		$query = DB::table('mef_service_status_information')
				 ->where('MEF_OFFICER_ID',$id)
				->first();

		if($query != null){
			return $query;
		} else {
			return array();
		}
	}

	public function getServiceStatus(){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$query = DB::table('mef_service_status_information')
				 ->where('MEF_OFFICER_ID',$userId)
				->first();

		if($query != null){
			return $query;
		} else {
			return array();
		}
		
	}

	public function postInsertSituationPublicInfo($data){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$array = array(
			'FIRST_START_WORKING_DATE_FOR_GOV'		=>isset($data['FIRST_START_WORKING_DATE_FOR_GOV']) ? $data['FIRST_START_WORKING_DATE_FOR_GOV']:'',
			'FIRST_GET_OFFICER_DATE'				=>isset($data['FIRST_GET_OFFICER_DATE']) ? $data['FIRST_GET_OFFICER_DATE']:'',
			'FIRST_OFFICER_CLASS'					=>isset($data['FIRST_OFFICER_CLASS']) ? $data['FIRST_OFFICER_CLASS']:'',
			'FIRST_OFFICE'							=>isset($data['FIRST_OFFICE']) ? $data['FIRST_OFFICE']:'',
			'FIRST_DEPARTMENT'						=>isset($data['FIRST_DEPARTMENT']) ? $data['FIRST_DEPARTMENT']:'',
			'FIRST_POSITION'						=>isset($data['FIRST_POSITION']) ? $data['FIRST_POSITION']:'',
			'FIRST_MINISTRY'						=>isset($data['FIRST_MINISTRY']) ? $data['FIRST_MINISTRY']:'',
			'FIRST_UNIT'							=>isset($data['FIRST_UNIT']) ? $data['FIRST_UNIT']:'',
			'ADDITINAL_UNIT'						=>isset($data['ADDITINAL_UNIT']) ? $data['ADDITINAL_UNIT']:'',
			'ADDITINAL_STATUS'						=>isset($data['ADDITINAL_STATUS']) ? $data['ADDITINAL_STATUS']:'',
			'ADDITIONAL_POSITION'					=>isset($data['ADDITIONAL_POSITION']) ? $data['ADDITIONAL_POSITION']:'',
			'ADDITIONAL_WORKING_DATE_FOR_GOV'		=>isset($data['ADDITIONAL_WORKING_DATE_FOR_GOV']) ? $data['ADDITIONAL_WORKING_DATE_FOR_GOV']:'',
			'CURRENT_OFFICE'						=>isset($data['CURRENT_OFFICE']) ? $data['CURRENT_OFFICE']:'',
			'CURRENT_DEPARTMENT'					=>isset($data['CURRENT_DEPARTMENT']) ? $data['CURRENT_DEPARTMENT']:'',
			'CURRENT_GENERAL_DEPARTMENT'			=>isset($data['CURRENT_GENERAL_DEPARTMENT']) ? $data['CURRENT_GENERAL_DEPARTMENT']:'',
			'CURRETN_PROMOTE_OFFICER_DATE'			=>isset($data['CURRETN_PROMOTE_OFFICER_DATE']) ? $data['CURRETN_PROMOTE_OFFICER_DATE']:'',
			'CURRENT_POSITION'						=>isset($data['CURRENT_POSITION']) ? $data['CURRENT_POSITION']:'',
			'CURRENT_GET_OFFICER_DATE'				=>isset($data['CURRENT_GET_OFFICER_DATE']) ? $data['CURRENT_GET_OFFICER_DATE']:'',
			'CURRENT_OFFICER_CLASS'					=>isset($data['CURRENT_OFFICER_CLASS']) ? $data['CURRENT_OFFICER_CLASS']:'',
			'IS_REGISTER'							=>intval(0)
		);
		/*  Histrory
			paratemter $table,$newFieldArray ($this->logModel->officerHistory($table,$newFieldArray))
			$table: table name, $$newFieldArray : new data insert
		*/
			//dd($array);
		$affected = DB::table('mef_service_status_information')
				->where('MEF_OFFICER_ID', $userId)
				->update($array);		
		return $affected;
	}

	public function getListSituation(){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$query = DB::table('mef_situation_outside_framwork')
				 ->where('MEF_OFFICER_ID',$userId)
				->first();

		if($query != null){
			return $query;
		} else {
			return array();
		}
		
	}

	public function insertSituation($data){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$affected = 0;
		foreach ($data as $key => $value) {
					$val["MEF_OFFICER_ID"] = $userId;
					$val["INSTITUTION"] = $value->INSTITUTION;
					$val["START_DATE"] = $value->START_DATE;
					$val["END_DATE"] = $value->END_DATE;
					$affected = DB::table('mef_situation_outside_framwork')
									->insert($val);
		}
		return $affected;
	}

	public function getListSituationFree(){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$query = DB::table('mef_situation_outside_framwork_free')
				 ->where('MEF_OFFICER_ID',$userId)
				->first();

		if($query != null){
			return $query;
		} else {
			return array();
		}
		
	}

	public function insertSituationFree($data){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$affected  = 0;
		foreach ($data as $key => $value) {
					$val["MEF_OFFICER_ID"] = $userId;
					$val["INSTITUTION"] = $value->INSTITUTION;
					$val["START_DATE"] = $value->START_DATE;
					$val["END_DATE"] = $value->END_DATE;
					$affected = DB::table('mef_situation_outside_framwork_free')
									->insert($val);
		}
		return $affected;
	}

	public function getListGeneralQualificationsFromOfficer($id){

		$query = DB::table('mef_general_qualifications')
				 ->where('MEF_OFFICER_ID',$id)
				->get();

		if($query != null){
			return $query;
		} else {
			return array();
		}
		
	}

	public function getListGeneralQualifications(){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		$query = DB::table('mef_general_qualifications')
				 ->where('MEF_OFFICER_ID',$userId)
				->get();

		if($query != null){
			return $query;
		} else {
			return array();
		}
		
	}

	public function insertGeneralQualifications($data){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		//dd($data);
		$affected = 0;
		foreach ($data as $key => $value) {
			$val["MEF_OFFICER_ID"] = $userId;
			$val["LEVEL"] = $value->LEVEL;
			$val["PLACE"] = $value->PLACE;
			$val["GRADUATION_MAJOR"] = $value->GRADUATION_MAJOR;
			$val["Q_START_DATE"] = $value->Q_START_DATE;
			$val["Q_END_DATE"] = $value->Q_END_DATE;
			$val["Q_TYPE"] = $value->Q_TYPE;
			$val["IS_REGISTER"] = intval(0);
			$affected = DB::table('mef_general_qualifications')
							->insert($val);
		}
		return $affected;
	}
	public function getAppreciationAwardsByOfficerId($id){
	 	$row = DB::table('mef_appreciation_awards')
	 	->where('MEF_OFFICER_ID', $id)
	 	->where('AWARD_TYPE',1)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getRelativesInformationOfficerId($id){
	 	$row = DB::table('mef_relatives_information')
	 	->where('FAMILY_STATUS_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function getForeignLanguagesOfficerId($id){
	 	$row = DB::table('mef_foreign_languages')
	 	->where('MEF_OFFICER_ID', $id)
	 	->get();
	 	if(count($row) > 0){
	 		return $row;
	 	}else{
	 		return $row = array();
	 	}
	}
	public function updateNotification(){
		$user = session('sessionGuestUser');
		$userId = $user->Id;
		DB::table('mef_notification')
				->where('TO_USER_ID', $userId)
				->where('STATUS', 1)
				->update(array('IS_READ' => 1));	
	}
}
