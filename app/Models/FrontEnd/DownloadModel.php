<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Input;


class DownloadModel{
	
    public function __construct(){

		$this->userGuestSession = session('sessionGuestUser');
    }
	
	public function getPersonalInfo($officerId){
		$query = DB::table('mef_officer AS of')
			->select('GENDER as gender','sec.Name','info.FULL_NAME_KH','info.FULL_NAME_EN','info.PLACE_OF_BIRTH','info.CURRENT_ADDRESS','info.PHONE_NUMBER_1','info.EMAIL')
			->join('mef_service_status_information AS serv','serv.MEF_OFFICER_ID','=','of.Id')
			->join('mef_secretariat AS sec','serv.FIRST_UNIT','=','sec.Id')
			->join('mef_personal_information AS info','info.MEF_OFFICER_ID','=','of.Id')
			->where('of.Id', $officerId)
			->first();
		if($query != null){
			return $query;
		} else {
			return array();
		}
	}
	
	public function getFamilySituationsById($userId){
		$userData = DB::table('mef_family_status')
		    ->join('mef_childrens','mef_family_status.ID', '=' ,'mef_childrens.FAMILY_STATUS_ID')
			->join('mef_relatives_information','mef_family_status.ID', '=' ,'mef_relatives_information.FAMILY_STATUS_ID')
			->where('MEF_OFFICER_ID', $userId)
			->get();
		$userStatus = DB::table('mef_personal_information')
			->select('MARRIED')
			->where('MEF_OFFICER_ID', $userId)
			->get();
		if(count($userData) > 0){
			$sibling = array(
				'RELATIVES_NAME_KH'      => json_decode($userData[0]->RELATIVES_NAME_KH),
				'RELATIVES_NAME_EN'	     => json_decode($userData[0]->RELATIVES_NAME_EN),
				'RELATIVES_NAME_GENDER'  => json_decode($userData[0]->RELATIVES_NAME_GENDER),
				'RELATIVES_NAME_DOB'     => json_decode($userData[0]->RELATIVES_NAME_DOB),
				'RELATIVES_NAME_JOB'     => json_decode($userData[0]->RELATIVES_NAME_JOB),
			);
			$children = array(
				'CHILDRENS_NAME_KH'      => json_decode($userData[0]->CHILDRENS_NAME_KH),
				'CHILDRENS_NAME_EN'	     => json_decode($userData[0]->CHILDRENS_NAME_EN),
				'CHILDRENS_NAME_GENDER'  => json_decode($userData[0]->CHILDRENS_NAME_GENDER),
				'CHILDRENS_NAME_DOB'     => json_decode($userData[0]->CHILDRENS_NAME_DOB),
				'CHILDRENS_NAME_JOB'     => json_decode($userData[0]->CHILDRENS_NAME_JOB),
				'CHILDRENS_NAME_SPONSOR' => json_decode($userData[0]->CHILDRENS_NAME_SPONSOR),
			);
			$phone = json_decode($userData[0]->SPOUSE_PHONE_NUMBER);
			unset($userData[0]->RELATIVES_NAME_KH);
			unset($userData[0]->RELATIVES_NAME_EN);
			unset($userData[0]->RELATIVES_NAME_GENDER);
			unset($userData[0]->RELATIVES_NAME_DOB);
			unset($userData[0]->RELATIVES_NAME_JOB);
			unset($userData[0]->CHILDRENS_NAME_KH);
			unset($userData[0]->CHILDRENS_NAME_EN);
			unset($userData[0]->CHILDRENS_NAME_GENDER);
			unset($userData[0]->CHILDRENS_NAME_DOB);
			unset($userData[0]->CHILDRENS_NAME_JOB);
			unset($userData[0]->CHILDRENS_NAME_SPONSOR);
			unset($userData[0]->SPOUSE_PHONE_NUMBER);
			return array("userData" => $userData[0],"userStatus" => $userStatus[0],"sibling" =>$sibling, "children" =>$children, "phone" =>$phone);
		}
		return array("userData" => array(),"userStatus" => array(), "sibling" => array(), "children" => array(), "phone" => array());
	}
	
	public function getSituationPublicInfoByUserId(){
		$data = $this->personalInfoModel->postGetSituationPublicInfoByUserId();
	}
	
}

?>