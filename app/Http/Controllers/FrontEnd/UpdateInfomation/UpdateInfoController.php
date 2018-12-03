<?php 
namespace App\Http\Controllers\FrontEnd\UpdateInfomation;
use App\Http\Controllers\FrontendController;

use App\libraries\Tool;
use DB;
use Input;
use Session;
use Illuminate\Http\Request;


use App\Models\FrontEnd\RegisterModel;
use App\Models\FrontEnd\UpdateInfoModel;
use App\Models\FrontEnd\PersonalInfoModel;
use App\Models\BackEnd\Officer\OfficerModel;
use App\Models\FrontEnd\CheckIsSubmitModel;

class UpdateInfoController extends FrontendController
{
	public function __construct(){
        parent::__construct();
		$this->user = session('sessionGuestUser');
		$this->userId = $this->user->Id;
		$this->registerModel = new RegisterModel();
		$this->userGuestSession = session('sessionGuestUser');
		$this->updateInfoModel = new UpDateInfoModel();
		$this->officer = new OfficerModel();
		$this->checkIsSubmitModel = new CheckIsSubmitModel();
    }
	function getApprove(){
		return view($this->viewFolder.'.Attendance.approve')->with($this->data);
		
	}
	public function getIndex(){
		return view($this->viewFolder.'.Attendance.index')->with($this->data);
	}
	public function postIndex(){
		$officerRequest = UpdateInfoModel::where('status', 1);
	}
	public function postRemoveNotification(Request $request){
		$affectedRow = DB::table('mef_officer_profile_transfer')
		 		->where('Id', $request->ID)
		 		->update(array('status'=>0));
		if($affectedRow){
			return json_encode(array('code'=>1,'message'=>'ទិន្នន័យត្រូវបានលុប', "description" => ""));
		}else{
			return json_encode(array('code'=>0,'message'=>'ដំនើរការលុបទិន្នន័យបរាជ័យ', "description" => ""));
		}
	}
	public function getAllOfficerRequest(){
		$array_data = $this->updateInfoModel->getListOfficerTransfer();
		return json_encode($array_data);
	}
	public function postAllOfficerRequest(Request $request){
		$result =$this->registerModel->checkUser($request);
		$officerRequest = 0;
		if($result != 0){
			$user = session('sessionGuestUser');
			$userId = $user->Id;
			$checkIsUrlSubmit = $this->checkIsSubmitModel->checkIsUrlSubmit();
			
			foreach($checkIsUrlSubmit as $key=>$val){
				if($key != 'awardSanction'){
					if($val == 0){
						return json_encode(array("code" => 0, "message" => "សូមបំពេញទិន្នន័យអោយបានគ្រប់គ្រាន់", "data" => ""));
					}
				}
			}
			$officerRequest= DB::table('mef_officer_profile_transfer')->insert([
				['to_officer_id' => $result, 'from_officer_id' => $userId]
			]);
			$this->updateInfoModel->postAccTransfer($result);
		}
		if($officerRequest == true){
			return json_encode(array('code'=>1,'message'=>'ទិន្ននយ័ត្រូវបានរក្សាទុកដោយជោគជយ័'));
		}else{
			return json_encode(array('code'=>0,'message'=>'ឈ្មោះនិងលេខកូដមិនត្រឹមត្រូវ សូមព្យាយាមម្តងទៀត'));
		}
	}
	
	public function getAllNotification(){
		$array_data = $this->updateInfoModel->getAllNotification();
		return json_encode($array_data);
	}
	public function postAllNotification(){
		$array_data = $this->updateInfoModel->getListOfficerTransfer();
		return json_encode($array_data);
	}
	
	public function getDetail($id=''){
        $this->data['tool'] = new Tool();
		$this->data['row'] = $this->officer->getPersonalInfByOfficerId($id);
		$this->data['serviceStatusInfoId'] = $this->officer->getSeviceStatusInfByOfficerId($id);
		$this->data['serviceStatusCurrentId'] = $this->officer->getSeviceStatusCurrentByOfficerId($id);
		$this->data['serviceStatusAdditioanlId'] = $this->officer->getSeviceStatusAdditonalByOfficerId($id);
		$this->data['situationOutsideId'] = $this->officer->getSituationOutSideFramworkByOfficerId($id);
		$this->data['situationFreeId'] = $this->officer->getSituationOutSideFreeByOfficerId($id);
		$this->data['familyStatusId'] = $this->officer->getFamilyStatusByOfficerId($id);
		$this->data['workingHistoryId'] = $this->officer->getWorkingHistoryByOfficerId($id);
		$this->data['workingHistoryPrivateId'] = $this->officer->getWorkingHistoryPrivateByOfficerId($id);
		$this->data['AppreciationAwardsId'] = $this->officer->getAppreciationAwardsByOfficerId($id);
		$this->data['appreciationSanctionId'] = $this->officer->getAppreciationSanctionByOfficerId($id);
		$this->data['generalQualificationsId'] = $this->officer->getGeneralQualificationsByOfficerId($id);
		$this->data['generalQualificationsSkillId'] = $this->officer->getGeneralQualificationsSkillByOfficerId($id);	
		$this->data['generalQualificationsTrainingId'] = $this->officer->getGeneralQualificationsTrainingOfficerId($id);
		$this->data['foreignLanguagesOfficerId'] = $this->officer->getForeignLanguagesOfficerId($id);
		$this->data['relativesInformationId'] = $this->officer->getRelativesInformationOfficerId($id);
		$this->data['childrenId'] = $this->officer->getChildrenOfficerId($id);	
		$this->data['phoneNumber'] = $this->officer->getPhoneNumber($id);	
		// dd($this->data);
		$this->data['userId']=$id;
		return view($this->viewFolder.'.background-staff-gov-info.detail')->with($this->data);
	}
	
	public function getProfileTransfer(){
		
	}
	public function postProfileTransfer(Request $request){
	
	}
	public function getConProfile(){
		return json_encode(array());
	}
	public function postConProfile(Request $request){
		$id = $request->id;
		$this->data['row'] = $this->officer->getPersonalInfByOfficerId($id);
		
		$this->data['serviceStatusInfoId'] = $this->officer->getSeviceStatusInfByOfficerId($id);
		$this->data['serviceStatusCurrentId'] = $this->officer->getSeviceStatusCurrentByOfficerId($id);
		$this->data['serviceStatusAdditioanlId'] = $this->officer->getSeviceStatusAdditonalByOfficerId($id);
		$this->data['situationOutsideId'] = $this->officer->getSituationOutSideFramworkByOfficerId($id);
		$this->data['situationFreeId'] = $this->officer->getSituationOutSideFreeByOfficerId($id);
		$this->data['familyStatusId'] = $this->officer->getFamilyStatusByOfficerId($id);
		$this->data['workingHistoryId'] = $this->officer->getWorkingHistoryByOfficerId($id);
		$this->data['workingHistoryPrivateId'] = $this->officer->getWorkingHistoryPrivateByOfficerId($id);
		$this->data['AppreciationAwardsId'] = $this->officer->getAppreciationAwardsByOfficerId($id);
		$this->data['appreciationSanctionId'] = $this->officer->getAppreciationSanctionByOfficerId($id);
		$this->data['generalQualificationsId'] = $this->officer->getGeneralQualificationsByOfficerId($id);
		$this->data['generalQualificationsSkillId'] = $this->officer->getGeneralQualificationsSkillByOfficerId($id);	
		$this->data['generalQualificationsTrainingId'] = $this->officer->getGeneralQualificationsTrainingOfficerId($id);
		$this->data['foreignLanguagesOfficerId'] = $this->updateInfoModel->getForeignLanguagesOfficerId($id);
		$this->data['relativesInformationId'] = $this->officer->getRelativesInformationOfficerId($id);
		$this->data['childrenId'] = $this->officer->getChildrenOfficerId($id);	
		// $this->data['phoneNumber'] = $this->officer->getPhoneNumber($id);
		$AppreciationAwardsId = 0;
		$familyStatusId = $this->familyStatusId($this->data['familyStatusId'],$this->data['relativesInformationId']);
		$workingHistoryId = $this->workingHistoryId($id);
		$workingHistoryPrivateId = $this->workingHistoryPrivateId($this->data['workingHistoryPrivateId']);
		if(sizeof($this->data['AppreciationAwardsId'])>0){
			$AppreciationAwardsId = $this->AppreciationAwardsId($this->data['AppreciationAwardsId']);
		}
		
		$foreignLanguagesOfficerId = $this->foreignLanguagesOfficerId($this->data['foreignLanguagesOfficerId']);
		
		$updateOwnProfile =$this->updateOwnProfile($this->data['row']);
		$serviceStatusInfoId = $this->serviceStatusInfoId($this->data['serviceStatusInfoId']);
		$situationOutsideId= $this->situationOutsideId($this->data['situationOutsideId']);
		$situationFreeIdsituationFreeId =$this->situationFreeId($this->data['situationFreeId']);
		$generalQualificationsId =$this->generalQualificationsId($this->data['generalQualificationsId']);
		
		if($familyStatusId ==1 && $workingHistoryId==1 && $workingHistoryPrivateId ==1
			&& $foreignLanguagesOfficerId==1 && $updateOwnProfile==1 && $serviceStatusInfoId==1
			&& $generalQualificationsId==1
		){
			DB::table('mef_notification')
				->where('TO_USER_ID', $this->userId)
				->update(['STATUS'   =>0]);
			return json_encode(array("code" => 1, "message" => "ទិន្នន័យត្រូវបានផ្ទេរដោយជោគជ័យ", "data" => ""));
		}else{
			// echo $familyStatusId."-".$workingHistoryId."-".$workingHistoryPrivateId."-".$foreignLanguagesOfficerId."-".$updateOwnProfile."-".$serviceStatusInfoId."-".$situationOutsideId."-".$situationFreeIdsituationFreeId."-".$generalQualificationsId;
			return json_encode(array("code" => 0, "message" => "ទិន្នន័យត្រូវបានផ្ទេរដោយជោគជ័យ", "data" => ""));
		}
	}
	
	public function updateOwnProfile($data){
		
		$persional = $this->updateInfoModel->getListPersional();
		if($persional->IS_REGISTER == null){
			$persionalData = array(
				 'GENDER' => $data->GENDER,
				 'CURRENT_ADDRESS' => $data->CURRENT_ADDRESS,
				 'PLACE_OF_BIRTH' => $data->PLACE_OF_BIRTH,
				 'NATIONALITY_1' => $data->NATIONALITY_1,
				 'NATIONALITY_2' => $data->NATIONALITY_2,
				 'MARRIED' => $data->MARRIED,
				 'DATE_OF_BIRTH' => $data->DATE_OF_BIRTH,
				 'PERSONAL_INFORMATION' => $persional->PERSONAL_INFORMATION,
				 'OFFICIAL_ID' => $persional->OFFICIAL_ID,
				 'UNIT_CODE' => $persional->UNIT_CODE,
				 'FULL_NAME_KH' => $persional->FULL_NAME_KH,
				 'FULL_NAME_EN' => $persional->FULL_NAME_EN,
				 'PASSPORT_ID_EXPIRED_DATE' => $persional->PASSPORT_ID_EXPIRED_DATE,
				 'PASSPORT_ID' => $persional->PASSPORT_ID,
				 'NATION_ID_EXPIRED_DATE' => $persional->NATION_ID_EXPIRED_DATE,
				 'NATION_ID' => $persional->NATION_ID,
				 'PHONE_NUMBER_1' => $persional->PHONE_NUMBER_1,
				 'PHONE_NUMBER_2' => $persional->PHONE_NUMBER_2,
				 'EMAIL' => $persional->EMAIL,
				 'AVATAR' => $persional->AVATAR,

				);
			
		}else{
			return;
		}
		//dd($persionalData);
		return $this->updateInfoModel->postInsertPersonalInfo($persionalData);
	}
	public function serviceStatusInfoId($data){
		$serviceStatusInfoOfficer = $this->updateInfoModel->getServiceStatusFromOfficer($data->MEF_OFFICER_ID);
		$serviceStatusInfo = $this->updateInfoModel->getServiceStatus();
		
		 if($serviceStatusInfo->IS_REGISTER == null){
		 	$serviceStatusData = array(
		 		'FIRST_START_WORKING_DATE_FOR_GOV' => $serviceStatusInfoOfficer->FIRST_START_WORKING_DATE_FOR_GOV ,
		 		'FIRST_GET_OFFICER_DATE' => $serviceStatusInfoOfficer->FIRST_GET_OFFICER_DATE , 
		 		'FIRST_OFFICER_CLASS' => $serviceStatusInfoOfficer->FIRST_OFFICER_CLASS ,

		 		'FIRST_OFFICE' => $serviceStatusInfo->FIRST_OFFICE , 
		 		'FIRST_DEPARTMENT' => $serviceStatusInfo->FIRST_DEPARTMENT ,

		 		'FIRST_POSITION' => $serviceStatusInfoOfficer->FIRST_POSITION , 

		 		'FIRST_MINISTRY' => $serviceStatusInfo->FIRST_MINISTRY , 
		 		'FIRST_UNIT' => $serviceStatusInfo->FIRST_UNIT , 

		 		'ADDITINAL_UNIT' => $serviceStatusInfoOfficer->ADDITINAL_UNIT , 
		 		'ADDITINAL_STATUS' => $serviceStatusInfoOfficer->ADDITINAL_STATUS , 
		 		'ADDITIONAL_POSITION' => $serviceStatusInfoOfficer->ADDITIONAL_POSITION , 
		 		'ADDITIONAL_WORKING_DATE_FOR_GOV' => $serviceStatusInfoOfficer->ADDITIONAL_WORKING_DATE_FOR_GOV , 

		 		'CURRENT_OFFICE' => $serviceStatusInfo->CURRENT_OFFICE , 
		 		'CURRENT_DEPARTMENT' => $serviceStatusInfo->CURRENT_DEPARTMENT , 
		 		'CURRENT_GENERAL_DEPARTMENT' => $serviceStatusInfo->CURRENT_GENERAL_DEPARTMENT , 

		 		'CURRETN_PROMOTE_OFFICER_DATE' => $serviceStatusInfoOfficer->CURRETN_PROMOTE_OFFICER_DATE , 
		 		'CURRENT_POSITION' => $serviceStatusInfoOfficer->CURRENT_POSITION , 
		 		'CURRENT_GET_OFFICER_DATE' => $serviceStatusInfoOfficer->CURRENT_GET_OFFICER_DATE , 
		 		'CURRENT_OFFICER_CLASS' => $serviceStatusInfoOfficer->CURRENT_OFFICER_CLASS ,  
		 		);

		}else{
			return 0;
		}
		
		return $this->updateInfoModel->postInsertSituationPublicInfo($serviceStatusData);
	}
	
	public function situationOutsideId($data){
		$situationOutside = $this->updateInfoModel->getListSituation();
		// return $situationOutside;
		if($situationOutside == null){
			return $this->updateInfoModel->insertSituation($data);
		}else{
			return 1;
		}
			
	}
	public function situationFreeId($data){
		$situationOutsideFree = $this->updateInfoModel->getListSituationFree();
		//dd($situationOutsideFree);
		if($situationOutsideFree == null){
			return $this->updateInfoModel->insertSituationFree($data);
		}else{
			return 0;
		}
	}
	public function familyStatusId($data,$relatives){
		$FamilyStatus =$this->officer->getFamilyStatusByOfficerId($this->userId);
		if(isset($FamilyStatus->IS_REGISTER)){
			if($FamilyStatus->IS_REGISTER !=1){
				DB::table('mef_family_status')->where('MEF_OFFICER_ID', $this->userId)->delete();	
				DB::table('mef_relatives_information')->where('FAMILY_STATUS_ID', $data->ID)->delete();					
				$val['MEF_OFFICER_ID'] = $this->userId;
				$val['FATHER_ADDRESS'] = $data->FATHER_ADDRESS;
				$val['FATHER_DOB'] = $data->FATHER_DOB;
				$val['FATHER_JOB'] = $data->FATHER_JOB;
				$val['FATHER_LIVE'] = $data->FATHER_LIVE;
				$val['FATHER_NAME_EN'] = $data->FATHER_NAME_EN;
				$val['FATHER_NAME_KH'] = $data->FATHER_NAME_KH;
				$val['FATHER_NATIONALITY_1'] = $data->FATHER_NATIONALITY_1;
				$val['FATHER_NATIONALITY_2'] = $data->FATHER_NATIONALITY_2;
				$val['FATHER_UNIT'] = $data->FATHER_UNIT;
				$val['MOTHER_ADDRESS'] = $data->MOTHER_ADDRESS;
				$val['MOTHER_DOB'] = $data->MOTHER_DOB;
				$val['MOTHER_JOB'] = $data->MOTHER_JOB;
				$val['MOTHER_LIVE'] = $data->MOTHER_LIVE;
				$val['MOTHER_NAME_EN'] = $data->MOTHER_NAME_EN;
				$val['MOTHER_NAME_KH'] = $data->MOTHER_NAME_KH;
				$val['MOTHER_NATIONALITY_1'] = $data->MOTHER_NATIONALITY_1;
				$val['MOTHER_NATIONALITY_2'] = $data->MOTHER_NATIONALITY_2;
				$val['MOTHER_UNIT'] = $data->MOTHER_UNIT;
				
				$insertGetId = DB::table('mef_family_status')
						->insertGetId($val);
				return $this->relativesInformationId($relatives,$insertGetId);	
			}else{
				return 0;
			}
		}else{
			$db_fam =DB::table('mef_family_status')->where('MEF_OFFICER_ID', $this->userId)->delete();		
			
			$val['MEF_OFFICER_ID'] = $this->userId;
			$val['FATHER_ADDRESS'] = $data->FATHER_ADDRESS;
			$val['FATHER_DOB'] = $data->FATHER_DOB;
			$val['FATHER_JOB'] = $data->FATHER_JOB;
			$val['FATHER_LIVE'] = $data->FATHER_LIVE;
			$val['FATHER_NAME_EN'] = $data->FATHER_NAME_EN;
			$val['FATHER_NAME_KH'] = $data->FATHER_NAME_KH;
			$val['FATHER_NATIONALITY_1'] = $data->FATHER_NATIONALITY_1;
			$val['FATHER_NATIONALITY_2'] = $data->FATHER_NATIONALITY_2;
			$val['FATHER_UNIT'] = $data->FATHER_UNIT;
			$val['MOTHER_ADDRESS'] = $data->MOTHER_ADDRESS;
			$val['MOTHER_DOB'] = $data->MOTHER_DOB;
			$val['MOTHER_JOB'] = $data->MOTHER_JOB;
			$val['MOTHER_LIVE'] = $data->MOTHER_LIVE;
			$val['MOTHER_NAME_EN'] = $data->MOTHER_NAME_EN;
			$val['MOTHER_NAME_KH'] = $data->MOTHER_NAME_KH;
			$val['MOTHER_NATIONALITY_1'] = $data->MOTHER_NATIONALITY_1;
			$val['MOTHER_NATIONALITY_2'] = $data->MOTHER_NATIONALITY_2;
			$val['MOTHER_UNIT'] = $data->MOTHER_UNIT;
			
			$insertGetId = DB::table('mef_family_status')
						->insertGetId($val);
			return $this->relativesInformationId($relatives,$insertGetId);		
		}
	}
	public function childrenId($chil,$ID){
		$val = array();
		foreach($chil as $key => $value){
			$val[$key]['CHILDRENS_NAME_DOB']= $value->CHILDRENS_NAME_DOB;
			$val[$key]['CHILDRENS_NAME_EN']= $value->CHILDRENS_NAME_EN;
			$val[$key]['CHILDRENS_NAME_GENDER']= $value->CHILDRENS_NAME_GENDER;
			$val[$key]['CHILDRENS_NAME_JOB']= $value->CHILDRENS_NAME_JOB;
			$val[$key]['CHILDRENS_NAME_KH']= $value->CHILDRENS_NAME_KH;
			$val[$key]['CHILDRENS_NAME_SPONSOR']= $value->CHILDRENS_NAME_SPONSOR;
			$val[$key]['FAMILY_STATUS_ID']= $ID->ID;
		}		
		return $affected = DB::table('mef_childrens')
							->insert($val);	
	}
	
	public function relativesInformationId($data,$ID){
		$relativesInfo =$this->officer->getRelativesInformationOfficerId($this->userId);
		if(isset($relativesInfo->IS_REGISTER)){
			if($relativesInfo->IS_REGISTER !=1){
				DB::table('mef_relatives_information')->where('MEF_OFFICER_ID', $this->userId)->delete();	
				$val = array();
				foreach($data as $key => $value){
					$val[$key]['RELATIVES_NAME_DOB']= $value->RELATIVES_NAME_DOB;
					$val[$key]['RELATIVES_NAME_EN']= $value->RELATIVES_NAME_EN;
					$val[$key]['RELATIVES_NAME_GENDER']= $value->RELATIVES_NAME_GENDER;
					$val[$key]['RELATIVES_NAME_JOB']= $value->RELATIVES_NAME_JOB;
					$val[$key]['RELATIVES_NAME_KH']= $value->RELATIVES_NAME_KH;
					$val[$key]['FAMILY_STATUS_ID']= $ID;
				}
				
				return $affected = DB::table('mef_relatives_information')
									->insert($val);	
			}else{
				return 0;
			}
		}else{
			DB::table('mef_relatives_information')->where('FAMILY_STATUS_ID', $ID)->delete();	
			$val = array();
			foreach($data as $key => $value){
				$val[$key]['RELATIVES_NAME_DOB']= $value->RELATIVES_NAME_DOB;
				$val[$key]['RELATIVES_NAME_EN']= $value->RELATIVES_NAME_EN;
				$val[$key]['RELATIVES_NAME_GENDER']= $value->RELATIVES_NAME_GENDER;
				$val[$key]['RELATIVES_NAME_JOB']= $value->RELATIVES_NAME_JOB;
				$val[$key]['RELATIVES_NAME_KH']= $value->RELATIVES_NAME_KH;
				$val[$key]['FAMILY_STATUS_ID']= $ID;
			}
			
			return $affected = DB::table('mef_relatives_information')
								->insert($val);	
		}
	}
	public function workingHistoryId($id){
		$History =$this->updateInfoModel->getWorkingHistoryByOfficerId($id);
		$workingHistory =$this->updateInfoModel->getWorkingHistoryByOfficerId($this->userId);
		
		if(isset($workingHistory[0]->IS_REGISTER)){
			if($workingHistory[0]->IS_REGISTER !=1){
				$affected = 0;
				DB::table('mef_work_history')->where('MEF_OFFICER_ID', $this->userId)->delete();		
				foreach($History as $key => $value){
					$val["START_WORKING_DATE"] = $value->START_WORKING_DATE;
					$val["END_WORKING_DATE"] = $value->END_WORKING_DATE;
					$val["DEPARTMENT"] = $value->DEPARTMENT;
					$val["INSTITUTION"] = $value->INSTITUTION;
					$val["POSITION"] = $value->POSITION;
					$val["POSITION_EQUAL_TO"] = $value->POSITION_EQUAL_TO;
					$val["IS_REGISTER"] = $value->IS_REGISTER;
					$val["MEF_OFFICER_ID"] = $this->userId;
					$affected = DB::table('mef_work_history')
								->insert($val);
				}	
				return $affected;
			}else{
				return 0;
			}
		}else{
			$affected = 0;
			foreach($History as $key => $value){				
				$val["START_WORKING_DATE"] = $value->START_WORKING_DATE;
				$val["END_WORKING_DATE"] = $value->END_WORKING_DATE;
				$val["DEPARTMENT"] = $value->DEPARTMENT;
				$val["INSTITUTION"] = $value->INSTITUTION;
				$val["POSITION"] = $value->POSITION;
				$val["POSITION_EQUAL_TO"] = $value->POSITION_EQUAL_TO;
				$val["IS_REGISTER"] = $value->IS_REGISTER;
				$val["MEF_OFFICER_ID"] = $this->userId;
				
				$affected = DB::table('mef_work_history')
							->insert($val);				
			}
			return $affected;
		}
	}
	public function workingHistoryPrivateId($data){
		$workingHistory = $this->officer->getWorkingHistoryPrivateByOfficerId($this->userId);
		if(isset($workingHistory[0]->IS_REGISTER)){
			if($workingHistory[0]->IS_REGISTER !=1){
				$affected = 0;
				DB::table('mef_working_history_private')->where('MEF_OFFICER_ID', $this->userId)->delete();		
				foreach($data as $key => $value){
					$val["IS_REGISTER"] = $value->IS_REGISTER;
					$val["PRIVATE_START_DATE"] = $value->PRIVATE_START_DATE;
					$val["PRIVATE_SKILL"] = $value->PRIVATE_SKILL;
					$val["PRIVATE_ROLE"] = $value->PRIVATE_ROLE;
					$val["PRIVATE_END_DATE"] = $value->PRIVATE_END_DATE;
					$val["PRIVATE_DEPARTMENT"] = $value->PRIVATE_DEPARTMENT;
					$val["MEF_OFFICER_ID"] = $this->userId;
					$affected = DB::table('mef_working_history_private')
								->insert($val);
				}
				return $affected;
			}else{
				return 0;
			}
		}else{
			$affected = 0;
			foreach($data as $key => $value){				
				$val["IS_REGISTER"] = $value->IS_REGISTER;
				$val["PRIVATE_START_DATE"] = $value->PRIVATE_START_DATE;
				$val["PRIVATE_SKILL"] = $value->PRIVATE_SKILL;
				$val["PRIVATE_ROLE"] = $value->PRIVATE_ROLE;
				$val["PRIVATE_END_DATE"] = $value->PRIVATE_END_DATE;
				$val["PRIVATE_DEPARTMENT"] = $value->PRIVATE_DEPARTMENT;
				$val["MEF_OFFICER_ID"] = $this->userId;
				
				$affected = DB::table('mef_working_history_private')
							->insert($val);				
			}
			return $affected;
		}
	}
	public function AppreciationAwardsId($data){
		$appreciationAwards =$this->updateInfoModel->getAppreciationAwardsByOfficerId($this->userId);
		$appreciationSanctionId =$this->updateInfoModel->getRelativesInformationOfficerId($this->userId);
		
		if(isset($appreciationAwards[0]) && isset($appreciationSanctionId[0])){
			if(($appreciationAwards[0]->IS_REGISTER ==1 ) || ($appreciationSanctionId[0]->IS_REGISTER == 1)){
				
			}else{
				DB::table('mef_appreciation_awards')->where('MEF_OFFICER_ID', $this->userId)->delete();	
				$val = array();
				$row = DB::table('mef_appreciation_awards')
				->where('MEF_OFFICER_ID', $data[0]->MEF_OFFICER_ID)
				->get();
				foreach($row as $key => $value){
					$val[$key]['AWARD_DATE']= $value->AWARD_DATE;
					$val[$key]['AWARD_DESCRIPTION']= $value->AWARD_DESCRIPTION;
					$val[$key]['AWARD_KIND']= $value->AWARD_KIND;
					$val[$key]['AWARD_NUMBER']= $value->AWARD_NUMBER;
					$val[$key]['AWARD_TYPE']= $value->AWARD_TYPE;
					$val[$key]['IS_REGISTER']= $value->IS_REGISTER;
					$val[$key]['MEF_OFFICER_ID']= $this->userId;
				}				
				return $affected = DB::table('mef_appreciation_awards')
									->insert($val);	
			}
		}else{
			DB::table('mef_appreciation_awards')->where('MEF_OFFICER_ID', $this->userId)->delete();	
			$val = array();
			$row = DB::table('mef_appreciation_awards')
				->where('MEF_OFFICER_ID', $data[0]->MEF_OFFICER_ID)
				->get();
			foreach($row as $key => $value){
				$val[$key]['AWARD_DATE']= $value->AWARD_DATE;
				$val[$key]['AWARD_DESCRIPTION']= $value->AWARD_DESCRIPTION;
				$val[$key]['AWARD_KIND']= $value->AWARD_KIND;
				$val[$key]['AWARD_NUMBER']= $value->AWARD_NUMBER;
				$val[$key]['AWARD_TYPE']= $value->AWARD_TYPE;
				$val[$key]['IS_REGISTER']= $value->IS_REGISTER;
				$val[$key]['MEF_OFFICER_ID']= $this->userId;
			}
			return $affected = DB::table('mef_appreciation_awards')
								->insert($val);	
		}
	}
	public function appreciationSanctionId($data){
		
	}
	public function generalQualificationsId($data){
		$generalQualificationsFrom = $this->updateInfoModel->getListGeneralQualificationsFromOfficer($data->MEF_OFFICER_ID);
		$generalQualifications = $this->updateInfoModel->getListGeneralQualifications();

		if(isset($generalQualifications[0]->IS_REGISTER)){			
			return 0;
		}else{
			return $this->updateInfoModel->insertGeneralQualifications($generalQualificationsFrom);
		}
	}
	public function generalQualificationsSkillId($data){
		
	}
	public function generalQualificationsTrainingId($data){
		
	}
	public function foreignLanguagesOfficerId($data){
		$ForeignLang =$this->updateInfoModel->getForeignLanguagesOfficerId($this->userId);
		if(sizeof($ForeignLang)>0){
			if($ForeignLang[0]->IS_REGISTER!=1){
				DB::table('mef_foreign_languages')->where('MEF_OFFICER_ID', $this->userId)->delete();	
				foreach($data as $key => $value){
					$val[$key]['LANGUAGE']= $value->LANGUAGE;
					$val[$key]['LISTEN']= $value->LISTEN;
					$val[$key]['WRITE']= $value->WRITE;
					$val[$key]['SPEAK']= $value->SPEAK;
					$val[$key]['RED']= $value->RED;
					$val[$key]['IS_REGISTER']= $value->IS_REGISTER;
					$val[$key]['MEF_OFFICER_ID']= $this->userId;
				}
				return $affected = DB::table('mef_foreign_languages')
									->insert($val);
			}
		}else{
			DB::table('mef_foreign_languages')->where('MEF_OFFICER_ID', $this->userId)->delete();	
			foreach($data as $key => $value){
				$val[$key]['LANGUAGE']= $value->LANGUAGE;
				$val[$key]['LISTEN']= $value->LISTEN;
				$val[$key]['WRITE']= $value->WRITE;
				$val[$key]['SPEAK']= $value->SPEAK;
				$val[$key]['RED']= $value->RED;
				$val[$key]['IS_REGISTER']= 1;
				$val[$key]['MEF_OFFICER_ID']= $this->userId;
			}
			return $affected = DB::table('mef_foreign_languages')
								->insert($val);
		}
	}
	public function postGetMessageId(Request $request){
		$array_data = $this->updateInfoModel->getSMSbyId($request->Id);
		return json_encode($array_data);
	}
	public function postUpdateNotification(){
		return $this->updateInfoModel->updateNotification();
	}
	
}