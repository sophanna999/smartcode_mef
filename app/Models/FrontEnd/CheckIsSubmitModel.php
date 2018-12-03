<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckIsSubmitModel{
	
	public function __construct()
    {
		$this->userGuestSession = session('sessionGuestUser');
    }
	
	public function checkIsUrlSubmit($editId=null){
		
		$arrayList	=	array(
			"personalInfo" => 0,
			"situationPublicInfo" => 0,
			"workingHistroy" => 0,
			"awardSanction" => 0,
			"generalKnowledge" => 0,
			"abilityForeignLanguage" => 0,
			"familySituations" => 0
		);
		$officerId = empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id;
		//dd($officerId);
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
			->orderBy('ID', 'asc')
			->first();
		if($awardSanctionType1 != null){
			$arrayList["awardSanction"]	=	$awardSanctionType1->IS_REGISTER;
		}		
		// generalKnowledge
		$generalKnowledge = DB::table('mef_general_qualifications')
			->where('MEF_OFFICER_ID', $officerId)
			->orderBy('ID', 'asc')
			->first();
		if($generalKnowledge != null){
			$arrayList["generalKnowledge"]	=	$generalKnowledge->IS_REGISTER;
		}		
		// abilityForeignLanguage
		$abilityForeignLanguage = DB::table('mef_foreign_languages')
			->where('MEF_OFFICER_ID', $officerId)
			->orderBy('ID', 'asc')
			->first();
		if($abilityForeignLanguage != null){
			$arrayList["abilityForeignLanguage"]	=	$abilityForeignLanguage->IS_REGISTER;
		}	
		// familySituations
		$familySituations = DB::table('mef_family_status')
			->where('MEF_OFFICER_ID', $officerId)
			->orderBy('ID', 'asc')
			->first();
		if($familySituations != null){
			$arrayList["familySituations"]	=	$familySituations->IS_REGISTER;
		}
		return $arrayList;
	}
	
	public function checkIsRegisterStatus($eidtId=null){
		$mefOfficer	= DB::table('mef_officer')->where('Id',empty($this->userGuestSession->Id) ? $eidtId : $this->userGuestSession->Id)->first();
		if($mefOfficer == null){
			return false;
		}
		return array("is_register" => $mefOfficer->is_register, "is_visited" => $mefOfficer->is_visited);
	}
	
	public function updateIsVisitedFirst($editId=null){
		$array = array(
			"is_visited" => 1
		);
		$affected = DB::table('mef_officer')
				->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)
				->update($array);		
		return $affected;
	}
	
	public function getIsSubmitAllForm($eidtId=null){
		$checkIsUrlSubmit = $this->checkIsUrlSubmit();
		foreach($checkIsUrlSubmit as $key=>$val){
			if($key != 'awardSanction'){
				if($val == 0){
					return json_encode(array("code" => 0, "message" => "សូមបំពេញទិន្នន័យដែលមានសញ្ញា(*)មុននឹងដាក់សំណើរ", "data" => ""));
				}
			}
		}
		if($this->checkIsRegisterStatus()["is_register"] != 0){
			return json_encode(array("code" => 0, "message" => "ប្រវត្តិរូបរបស់អ្នកធ្លាប់បានដាក់សំណើររួចហើយ", "data" => ""));
		}
		$array = array(
			"is_register" => 1
		);
		$affected = DB::table('mef_officer')
				->where('Id',empty($this->userGuestSession->Id) ? $eidtId : $this->userGuestSession->Id)
				->update($array);
		return json_encode(array("code" => 1, "message" => "ប្រវត្តិរូបរបស់អ្នកត្រូវបានដាក់សំណើរបានជោគជ៏យ", "data" => ""));
	}
}
?>