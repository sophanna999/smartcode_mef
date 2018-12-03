<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\libraries\Tool;

class PersonalInfoModel{

	public function __construct()
    {
        $this->userGuestSession = session('sessionGuestUser');
		$this->Tool = new Tool();
		$this->logModel = new LogModel();
    }
	public function getSituationOutFrameworkType(){
		$list = DB::table('mef_situation_outside_framwork_type')
			->OrderBy('ID', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->NAME,
				"value" =>$row->ID
			);
		}
		return json_encode($arrList);
	}
	public function getAllPositions(){
		$list = DB::table('mef_position')
			->OrderBy('ORDER_NUMBER', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->NAME,
				"value" =>$row->ID
			);
		}
		return json_encode($arrList);
	}
	public function getAllDepartment(){
		$list = DB::table('mef_ministry')
			->OrderBy('Name', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return json_encode($arrList);
	}
	public function postSavePersonalInfo($data){
		$editId = empty($this->userGuestSession->Id) ? $data['editId'] : $this->userGuestSession->Id;
		$address = $data['data']['address'];
		$avatarStatus	=	false;
		$pathAvatar		=	null;
		$avatarObj = explode(',',$data['data']['objInfo']['AVATAR']);
		if(count($avatarObj) == 2){
			$base64File = base64_decode($avatarObj[1]);
			$extensionFile	=	$this->Tool->before_last(';',($this->Tool->after_last("/",$avatarObj[0])));
			$path   = 'files/officer/' . $this->userGuestSession->user_name .'/';
			$randomString   =   $this->Tool->mt_rand_str(5,'1234567890');
			$fileName       =   time().'_'.$randomString.'.'.$extensionFile;
			$status 		=   Storage::disk('public')->put($path.$fileName, $base64File);
			$avatarStatus   = 	true;
			$pathAvatar		=	$path.$fileName;
			$getInformation = DB::table('mef_personal_information')
				->where('MEF_OFFICER_ID',$editId)
				->first();
			if($getInformation->AVATAR != null || $getInformation->AVATAR != ''){
				if(file_exists( public_path() . '/' . $getInformation->AVATAR)){
					Storage::disk('public')->delete($getInformation->AVATAR);
				}
			}
		}
		$obj = isset($data['data']['objInfo']) ? $data['data']['objInfo']:'';
		$dob = '';$nationId = '';$passportId = '';
		if($data['data']['DATE_OF_BIRTH'] != ''){
			$dob = $data['data']['DATE_OF_BIRTH'];
		}
		if($data['data']['NATION_ID_EXPIRED_DATE'] != ''){
			$nationId = $data['data']['NATION_ID_EXPIRED_DATE'];
		}
		if($data['data']['PASSPORT_ID_EXPIRED_DATE'] != ''){
			$passportId = $data['data']['PASSPORT_ID_EXPIRED_DATE'];
		}
		$array = array(
			'PERSONAL_INFORMATION'		=>isset($obj['PERSONAL_INFORMATION']) ? $obj['PERSONAL_INFORMATION']:'',
			'OFFICIAL_ID'				=>isset($obj['OFFICIAL_ID']) ? $obj['OFFICIAL_ID']:'',
			'UNIT_CODE'					=>isset($obj['UNIT_CODE']) ? $obj['UNIT_CODE']:'',
			'TITLE_ID'					=>isset($obj['TITLE_ID']) ? $obj['TITLE_ID']:'',
			'FULL_NAME_KH'				=>isset($obj['FULL_NAME_KH']) ? $obj['FULL_NAME_KH']:'',
			'FULL_NAME_EN'				=>isset($obj['FULL_NAME_EN']) ? $obj['FULL_NAME_EN']:'',
			'PASSPORT_ID_EXPIRED_DATE'	=>$passportId,
			'DATE_OF_BIRTH'				=>$dob,
			'NATION_ID_EXPIRED_DATE'	=>$nationId,
			'GENDER'					=>isset($obj['GENDER']) ? $obj['GENDER']:'ប្រុស' ,
			'PASSPORT_ID'				=>isset($obj['PASSPORT_ID']) ? $obj['PASSPORT_ID']:'',
			'NATION_ID'					=>isset($obj['NATION_ID']) ? $obj['NATION_ID']:'',
			'PHONE_NUMBER_1'			=>isset($obj['PHONE_NUMBER_1']) ? $obj['PHONE_NUMBER_1']:'',
			'PHONE_NUMBER_2'			=>isset($obj['PHONE_NUMBER_2']) ? $obj['PHONE_NUMBER_2']:'',
			'EMAIL'						=>isset($obj['EMAIL']) ? $obj['EMAIL']:'',
			// 'CURRENT_ADDRESS'			=>isset($obj['CURRENT_ADDRESS']) ? $obj['CURRENT_ADDRESS']:'',
			'PLACE_OF_BIRTH'			=>isset($obj['PLACE_OF_BIRTH']) ? $obj['PLACE_OF_BIRTH']:'',
			'NATIONALITY_1'				=>isset($obj['NATIONALITY_1']) ? $obj['NATIONALITY_1']:'',
			'NATIONALITY_2'				=>isset($obj['NATIONALITY_2']) ? $obj['NATIONALITY_2']:'',
			'MARRIED'					=>isset($obj['MARRIED']) && $obj['MARRIED'] == true ? 1:0,
			'AVATAR'					=>$pathAvatar,
			'IS_REGISTER'				=>intval($data["IS_REGISTER"])

		);
		//dd($array);
		if($array['MARRIED'] == 1){
			$data = DB::table('mef_family_status')->where('MEF_OFFICER_ID', $editId)->get();
			if(count($data) > 0){
				$data_child = DB::table('mef_childrens')->where('FAMILY_STATUS_ID', $data[0]->ID)->get();
				$spouse = array(
				   "SPOUSE_PHONE_NUMBER" => null,
				   "SPOUSE_SPONSOR"		 => null,
				   "SPOUSE_UNIT"		 => null,
				   "SPOUSE_JOB"			 => null,
				   "SPOUSE_POB"          => null,
				   "SPOUSE_NATIONALITY_1" => null,
				   "SPOUSE_NATIONALITY_2" => null,
				   "SPOUSE_DOB"			  => null,
				   "SPOUSE_LIVE"		  => null,
				   "SPOUSE_NAME_EN"		  => null,
				   "SPOUSE_NAME_KH"		  => null,
				);
//				DB::table('mef_childrens')->where('FAMILY_STATUS_ID', $data[0]->ID)->delete();
//				DB::table('mef_family_status')->where('MEF_OFFICER_ID', $editId)->update($spouse);
			}
		}

		if($avatarStatus == false){
			unset($array["AVATAR"]);
		}
		/* Validation */
		$dataValidation = array();
		$ValidationEmail = DB::table('mef_officer as mf')
				->join('mef_personal_information as mpi', 'mpi.MEF_OFFICER_ID', '=', 'mf.Id')
				->where('mpi.MEF_OFFICER_ID', '<>' ,$editId)
				->where('mpi.EMAIL',$array["EMAIL"])
				//By Menglay for select info not approve
				->whereRaw("IFNULL(mf.approve,'')=''")
				->get();
		if(count($ValidationEmail) > 0){
			$dataValidation["EMAIL"] = "អ៊ីម៉ែលនេះបានប្រើប្រាស់រួចហើយ";
		}

		/* Update Mef Officer is_register Status End */
		if(count($dataValidation) > 0){
			return json_encode(array("code" => 0, "message" => "អ៊ីម៉ែលនេះបានប្រើប្រាស់រួចហើយ", "description" => $dataValidation));
		}
		/* Condition Email and Phone Number Blanck */
		if($array["EMAIL"] == "" || $array["EMAIL"] == null){
			unset($array["EMAIL"]);
		}
		if($array["PHONE_NUMBER_1"] == "" || $array["PHONE_NUMBER_1"] == null){
			unset($array["PHONE_NUMBER_1"]);
		}
		/* Condition Email and Phone Number Blanck End */
		/* Validation End */
		/* 	Histrory
			paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
			$formNumber : form number
			$table: table name
			$newFieldArray : new data insert
			$isMultipleRow : Single Row : 0 , Muliple Rows : 1
			$mefFormTitle : Form title
		*/
		//		modify by menglay
		/* Update Mef Officer is_register Status */
		if($array["IS_REGISTER"] == 0){
			$this->logModel->updateMefOfficerIsRegister(0,$editId);
		}
		$this->logModel->officerHistory(1,'mef_personal_information',$array,0,"ព័ត៌មានផ្ទាល់ខ្លួន",null,$editId);
		$currentArr = array(
				"is_register" => $array["IS_REGISTER"],
				"mef_province_id" => $address["mef_province_id"],
				"mef_district_id" => $address["mef_district_id"],
				"mef_commune_id" => $address["mef_commune_id"],
				"mef_village_id" => $address["mef_village_id"],
				"house" => $address["house"],
				"street" => $address["street"]
			);
		$affectedRow = DB::table('mef_personal_information')
				->where('MEF_OFFICER_ID', $editId)
				->update($array);
		$currentArrRow = DB::table('mef_officer_current_address')
				->where('mef_officer_id', $editId)
				->update($currentArr);
		return json_encode(array('code'=>1,'message'=>'ព័ត៌មានផ្ទាល់ខ្លួនត្រូវបានរក្សាទុក', "description" => ""));
	}
	public function postSaveSituationPublicInfo($data){
		$obj = $data['data'];
		$array = array(
			'FIRST_START_WORKING_DATE_FOR_GOV'		=>isset($obj['FIRST_START_WORKING_DATE_FOR_GOV']) ? $obj['FIRST_START_WORKING_DATE_FOR_GOV']:'',
			'FIRST_GET_OFFICER_DATE'				=>isset($obj['FIRST_GET_OFFICER_DATE']) ? $obj['FIRST_GET_OFFICER_DATE']:'',
			'FIRST_OFFICER_CLASS'					=>isset($obj['FIRST_OFFICER_CLASS']) ? $obj['FIRST_OFFICER_CLASS']:'',
			'FIRST_OFFICE'							=>isset($obj['FIRST_OFFICE']) ? $obj['FIRST_OFFICE']:'',
			'FIRST_DEPARTMENT'						=>isset($obj['FIRST_DEPARTMENT']) ? $obj['FIRST_DEPARTMENT']:'',
			'FIRST_POSITION'						=>isset($obj['FIRST_POSITION']) ? $obj['FIRST_POSITION']:'',
			'FIRST_MINISTRY'						=>isset($obj['FIRST_MINISTRY']) ? $obj['FIRST_MINISTRY']:'',
			'FIRST_UNIT'							=>isset($obj['FIRST_UNIT']) ? $obj['FIRST_UNIT']:'',
			'ADDITINAL_UNIT'						=>isset($obj['ADDITINAL_UNIT']) ? $obj['ADDITINAL_UNIT']:'',
			'ADDITINAL_STATUS'						=>isset($obj['ADDITINAL_STATUS']) ? $obj['ADDITINAL_STATUS']:'',
			'ADDITIONAL_POSITION'					=>isset($obj['ADDITIONAL_POSITION']) ? $obj['ADDITIONAL_POSITION']:'',
			'ADDITIONAL_WORKING_DATE_FOR_GOV'		=>isset($obj['ADDITIONAL_WORKING_DATE_FOR_GOV']) ? $obj['ADDITIONAL_WORKING_DATE_FOR_GOV']:'',
			'CURRENT_OFFICE'						=>isset($obj['CURRENT_OFFICE']) ? $obj['CURRENT_OFFICE']:'',
			'CURRENT_MINISTRY'						=>isset($obj['CURRENT_MINISTRY']) ? $obj['CURRENT_MINISTRY']:'',
			'CURRENT_DEPARTMENT'					=>isset($obj['CURRENT_DEPARTMENT']) ? $obj['CURRENT_DEPARTMENT']:'',
			'CURRENT_GENERAL_DEPARTMENT'			=>isset($obj['CURRENT_GENERAL_DEPARTMENT']) ? $obj['CURRENT_GENERAL_DEPARTMENT']:'',
			'CURRETN_PROMOTE_OFFICER_DATE'			=>isset($obj['CURRETN_PROMOTE_OFFICER_DATE']) ? $obj['CURRETN_PROMOTE_OFFICER_DATE']:'',
			'CURRENT_POSITION'						=>isset($obj['CURRENT_POSITION']) ? $obj['CURRENT_POSITION']:'',
			'CURRENT_GET_OFFICER_DATE'				=>isset($obj['CURRENT_GET_OFFICER_DATE']) ? $obj['CURRENT_GET_OFFICER_DATE']:'',
			'CURRENT_OFFICER_CLASS'					=>isset($obj['CURRENT_OFFICER_CLASS']) ? $obj['CURRENT_OFFICER_CLASS']:'',
			'IS_REGISTER'							=>intval($data["IS_REGISTER"]),
		);
		/* 	Histrory
			paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
			$formNumber : form number
			$table: table name
			$newFieldArray : new data insert
			$isMultipleRow : Single Row : 0 , Muliple Rows : 1
			$mefFormTitle : Form title
		*/
		//		modify by menglay
		/* Update Mef Officer is_register Status */
		if($array["IS_REGISTER"] == 0){
			$this->logModel->updateMefOfficerIsRegister(0,empty($this->userGuestSession->Id) ? $data['editId'] : $this->userGuestSession->Id);
		}/* Update Mef Officer is_register Status End */
		$this->logModel->officerHistory(2,'mef_service_status_information',$array,0,"ព័ត៌មានស្ថានភាពមុខងារ",null,empty($this->userGuestSession->Id) ? $data['editId'] : $this->userGuestSession->Id);
		$affected = DB::table('mef_service_status_information')
				->where('MEF_OFFICER_ID', empty($this->userGuestSession->Id) ? $data['editId'] : $this->userGuestSession->Id)
				->update($array);
		return $affected;
	}
	public function getPersonalInfByUserId($eidtId=null){
		$row = DB::table('mef_personal_information')->where('MEF_OFFICER_ID', empty($this->userGuestSession->Id) ? $eidtId : $this->userGuestSession->Id)->first();
		//dd($row);
		if(count($row) > 0){
			$row->CURRENT_ADDRESS = $this->getCurrentAddress(empty($this->userGuestSession->Id) ? $eidtId : $this->userGuestSession->Id);
			$row->district_obj = $this->getDistrict($row->CURRENT_ADDRESS->mef_province_id);
			$row->commune_obj = $this->getCommune($row->CURRENT_ADDRESS->mef_district_id);
			$row->village_obj = $this->getVillages($row->CURRENT_ADDRESS->mef_commune_id);
			$row->title_obj = $this->getTitle();
			return $row;
		}
	}
	private function getTitle($id='')
	{
		if(empty($id)){
			$listDb = DB::table('mef_title')->select('id as value','name as text')->get();
			$array = array(array("text"=>"", "value" => ""));
			return $result = array_merge($array, $listDb);
		}
	}
	private function getCurrentAddress($eidtId=null){
		$row = DB::table('mef_officer_current_address')->where('mef_officer_id', empty($this->userGuestSession->Id) ? $eidtId : $this->userGuestSession->Id)->first();
		if(count($row) > 0){
			return $row;
		}else{
			return (object)array("house" => "", "street" => "", "mef_province_id" => "", "mef_district_id" => "", "mef_commune_id" => "", "mef_village_id" => "");
		}
	}
	public function postGetSituationPublicInfoByUserId($editId=null){
		//dd($eidtId);
		$row = DB::table('mef_service_status_information')->where('MEF_OFFICER_ID', empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)->first();
		if(count($row) > 0){
			return $row;
		}
	}
	public function postGetSituationOutSideFrameWorkByServiceStatusId($serviceStatusId){
		$array = DB::table('mef_situation_outside_framwork')
					->where('MEF_OFFICER_ID', $serviceStatusId)
					->OrderBy('ID', 'asc')
					->get();
		return $array;
	}
	public function postSaveSituationOutSideFrameWorkByServiceStatusId($serviceStatusId,$data = array(),$editId=null){
		foreach($data as $key=>$val){
			$data[$key]["MEF_OFFICER_ID"] = $serviceStatusId;
			if(isset($data[$key]["ID"])){
				unset($data[$key]["ID"]);
			}
			if(
				$val["INSTITUTION"] == "" ||
				$val["START_DATE"] == "" ||
				$val["END_DATE"] == ""
			)
			{
				unset($data[$key]);
			}else{
				$data[$key]["START_DATE"] == "" ? $data[$key]["START_DATE"] = '0000-00-00' : $data[$key]["START_DATE"] = $data[$key]["START_DATE"];
				$data[$key]["END_DATE"] == "" ? $data[$key]["END_DATE"] = '0000-00-00' : $data[$key]["END_DATE"] = $data[$key]["END_DATE"];
				$data[$key]["END_DATE"] == "undefined-undefined-" ? $data[$key]["END_DATE"] = '0000-00-00' : $data[$key]["END_DATE"] = $data[$key]["END_DATE"];
			}
		}
		/* 	Histrory
			paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
			$formNumber : form number
			$table: table name
			$newFieldArray : new data insert
			$isMultipleRow : Single Row : 0 , Muliple Rows : 1
			$mefFormTitle : Form title
		*/
		//		modify by menglay
		$this->logModel->officerHistory(2,'mef_situation_outside_framwork',$data,1,"ព័ត៌មានស្ថានភាពមុខងារ",null,empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id);
		DB::table('mef_situation_outside_framwork')->where('MEF_OFFICER_ID', $serviceStatusId)->delete();
		$affected = DB::table('mef_situation_outside_framwork')
				->where('MEF_OFFICER_ID', $serviceStatusId)
				->insert($data);
		return $affected;
	}
	public function postGetSituationOutSideFrameWorkFreeByServiceStatusId($serviceStatusId){
		$array = DB::table('mef_situation_outside_framwork_free')
					->where('MEF_OFFICER_ID', $serviceStatusId)
					->get();
		return $array;
	}
	public function postSaveSituationOutSideFrameWorkFreeByServiceStatusId($serviceStatusId,$data = array(),$editId=null){
		foreach($data as $key=>$val){
			$data[$key]["MEF_OFFICER_ID"] = $serviceStatusId;
			if(isset($data[$key]["ID"])){
				unset($data[$key]["ID"]);
			}
			if(
				$val["INSTITUTION"] == "" &&
				$val["START_DATE"] == "" &&
				$val["END_DATE"] == ""
			)
			{
				unset($data[$key]);
			}else{
				$data[$key]["START_DATE"] == "" ? $data[$key]["START_DATE"] = '0000-00-00' : $data[$key]["START_DATE"] = $data[$key]["START_DATE"];
				$data[$key]["END_DATE"] == "" ? $data[$key]["END_DATE"] = '0000-00-00' : $data[$key]["END_DATE"] = $data[$key]["END_DATE"];
			}
		}
		/* 	Histrory
			paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
			$formNumber : form number
			$table: table name
			$newFieldArray : new data insert
			$isMultipleRow : Single Row : 0 , Muliple Rows : 1
			$mefFormTitle : Form title
		*/
		//		modify by menglay
		$this->logModel->officerHistory(2,'mef_situation_outside_framwork_free',$data,1,"ព័ត៌មានស្ថានភាពមុខងារ",null,empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id);
		DB::table('mef_situation_outside_framwork_free')->where('MEF_OFFICER_ID', $serviceStatusId)->delete();
		$affected = DB::table('mef_situation_outside_framwork_free')
				->where('MEF_OFFICER_ID', $serviceStatusId)
				->insert($data);
		return $affected;
	}
	public function getSecretariatListByMinistryId($ministryId){
		$rows = DB::table('mef_secretariat')->where('mef_ministry_id', $ministryId)->get();
		$array = array();
		$array[] = array("text" => "","value" => 0);
		foreach($rows as $row){
			if($row->Abbr != ''){
        		$str = ' -'.$row->Abbr;
        	}else{
        		$str = '';
        	}
			$array[] = array(
						"text" => $row->Name.$str,
						"value" => $row->Id
						);
		}
		return $array;
	}
	public function getDepartmentListBySecretariatId($secretariatId){
		$rows = DB::table('mef_department')->where('mef_secretariat_id', $secretariatId)->orWhere('Name','មិនមាន')->get();
		$array = array();
		$array[] = array("text" => "","value" => 0);
		foreach($rows as $row){
			if($row->Abbr != ''){
        		$str = ' -'.$row->Abbr;
        	}else{
        		$str = '';
        	}
			$array[] = array(
						"text" => $row->Name.$str,
						"value" => $row->Id
						);
		}
		return $array;
	}
	public function getFirstOfficeListBydepartmentId($departmentId){
		$rows = DB::table('mef_office')->where('mef_department_id', $departmentId)->orWhere('Name','មិនមាន')->get();
		$array = array();
		$array[] = array("text" => "","value" => 0);
		foreach($rows as $row){
			if($row->Abbr != ''){
        		$str = ' -'.$row->Abbr;
        	}else{
        		$str = '';
        	}
			$array[] = array(
						"text" => $row->Name.$str,
						"value" => $row->Id
						);
		}
		return $array;
	}
	public function getAllOffice(){
		$list = DB::table('mef_office')
			->OrderBy('Name', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return json_encode($arrList);
	}
	public function getAllClassRanks(){
		$list = DB::table('mef_class_ranks')
			->OrderBy('Order', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return json_encode($arrList);
	}
	public function getAllDepartmentsOffice(){
		$list = DB::table('mef_department')
			->OrderBy('Id', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return json_encode($arrList);
	}
	public function getListProvinceJson(){
		$list = DB::table('mef_province')
			->OrderBy('name_kh', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->name_kh,
				"value" =>$row->id
			);
		}
		return json_encode($arrList);
	}
	public function getDistrict($provinceId){
		$list = DB::table('mef_districts')
			->where('mef_province_id',$provinceId)
			->OrderBy('name_kh', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->name_kh,
				"value" =>$row->id
			);
		}
		return $arrList;
	}
	public function getCommune($districtId){
		$list = DB::table('mef_commune')
			->where('mef_district_id',$districtId)
			->OrderBy('name_kh', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->name_kh,
				"value" =>$row->id
			);
		}
		return $arrList;
	}
	public function getVillages($communeId){
		$list = DB::table('mef_villages')
			->where('mef_commune_id',$communeId)
			->OrderBy('name_kh', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->name_kh,
				"value" =>$row->id
			);
		}
		return $arrList;
	}
}
?>
