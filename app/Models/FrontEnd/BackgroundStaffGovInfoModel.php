<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Input;

class BackgroundStaffGovInfoModel{

    public function __construct(){
		$this->userGuestSession = session('sessionGuestUser');
		$this->logModel = new LogModel();
    }

	public function getTypeCourse(){
		$list = DB::table('mef_type_course')
			->orderBy('ID', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->NAME,
				"value" =>$row->ID
			);
		}
		return $arrList;
	}

	public function getTypeQualifications(){
		$list = DB::table('mef_type_qualifications')
			->orderBy('ID', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->NAME,
				"value" =>$row->ID
			);
		}
		return $arrList;
	}

	public function getGeneralKnowledgeById($userId){
      $result['knowledge_g'] =DB::table('mef_general_qualifications')
        ->select('LEVEL','PLACE','GRADUATION_MAJOR','Q_START_DATE','Q_END_DATE','Q_TYPE','MEF_OFFICER_ID')
        ->where('MEF_OFFICER_ID', $userId)->where('Q_TYPE',1)->first();

      $result['knowledge_sk'] =DB::table('mef_general_qualifications')
  			->select('LEVEL','PLACE','GRADUATION_MAJOR','Q_START_DATE','Q_END_DATE','Q_TYPE','MEF_OFFICER_ID')
  			->where('MEF_OFFICER_ID', $userId)->where('Q_TYPE',2)->orderBy('ID')->get();

      $result['knowledge_un'] =DB::table('mef_general_qualifications')
  			->select('LEVEL','PLACE','GRADUATION_MAJOR','Q_START_DATE','Q_END_DATE','Q_TYPE','MEF_OFFICER_ID')
  			->where('MEF_OFFICER_ID', $userId)->where('Q_TYPE',3)->orderBy('ID')->get();
      return $result;

		return array(
			"2" => array(),
			"3" => array(),
		);
	}

	public function getUnderDegree(){
		$list = DB::table('mef_degree')
			->where('Type',1)
			->orderBy('Order', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return $arrList;
	}

	public function getUnderSkill(){
		$list = DB::table('mef_degree')
			->where('Type','<>',1)
			->orderBy('Order', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return $arrList;
	}

	public function getDegree(){
		$list = DB::table('mef_degree')
		    ->where('Type',0)
			->orderBy('Order', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return $arrList;
	}

	public function getSkill(){
		$list = DB::table('mef_skill')
			->where('Type',0)
			->orderBy('Order', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return $arrList;
	}

	public function saveGeneralKnowledge($data,$userId){
		if($data['numFild'] == 0){
			$two = array();
			$three = array();
			foreach($data['objectKnowledgeTow'] as $k_two => $v_two){
				if(!empty($v_two)){
					if($v_two['LEVEL'] == '' && $v_two['PLACE'] == '' && $v_two['GRADUATION_MAJOR'] == '' && $v_two['Q_START_DATE'] == '' && $v_two['Q_END_DATE'] == ''){
						unset($k_two);
					} else {
						$two[] = $v_two;
					}
				}
			}
			foreach($data['objectKnowledgeThree'] as $k_three => $v_three){
				if(!empty($v_three)){
					if($v_three['LEVEL'] == '' && $v_three['PLACE'] == '' && $v_three['GRADUATION_MAJOR'] == '' && $v_three['Q_START_DATE'] == '' && $v_three['Q_END_DATE'] == ''){
						unset($k_three);
					} else {
						$three[] = $v_three;
					}
				}
			}
			/* Block History general-knowledge */
			$oneArray = array(0=>$data['objectKnowledgeOne']);
			$dataMerge = array_merge($oneArray, $two, $three);
			/* 	Histrory
				paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
				$formNumber : form number
				$table: table name
				$newFieldArray : new data insert
				$isMultipleRow : Single Row : 0 , Muliple Rows : 1
				$mefFormTitle : Form title
			*/

//			modify by menglay
			$this->logModel->officerHistory(5,'mef_general_qualifications',$dataMerge,1,"កំរិតវប្បធម៌ទូទៅ ការបណ្តុះបណ្តាលវិជ្ជាជីវៈ និងការបណ្តុះបណ្តាលបន្ត",null,$userId);

			/* Block History general-knowledge End */
			$this->modifiedData($data['objectKnowledgeOne'],$userId,1,'completed');
			$this->modifiedData($two,$userId,2,'completed');
			if(!empty($three)){
				$this->modifiedData($three,$userId,3,'completed');
			}
			return json_encode(array("code" => 1, "message" => "កំរិតវប្បធម៌ទូទៅ ការបណ្តុះបណ្តាលវិជ្ជាជីវៈនិងការបណ្តុះបណ្តាលបន្តត្រូវបានរក្សាទុក្ខ", "data" => ""));
		}else if($data['numFild'] > 0 && $data['numFild'] < 10 ){
			$one = $data['objectKnowledgeOne'];
			if($one['LEVEL'] == '' && $one['PLACE'] == null && $one['GRADUATION_MAJOR'] == '' && $one['Q_START_DATE'] == '' && $one['Q_END_DATE'] == ''){
				$one = array();
			}
			$two = array();
			$three = array();
			foreach($data['objectKnowledgeTow'] as $k_two => $v_two){
				if(!empty($v_two)){
					if($v_two['LEVEL'] == '' && $v_two['PLACE'] == '' && $v_two['GRADUATION_MAJOR'] == '' && $v_two['Q_START_DATE'] == '' && $v_two['Q_END_DATE'] == ''){
						unset($k_two);
					} else {
						$two[] = $v_two;
					}
				}
			}
			foreach($data['objectKnowledgeThree'] as $k_three => $v_three){
				if(!empty($v_three)){
					if($v_three['LEVEL'] == '' && $v_three['PLACE'] == '' && $v_three['GRADUATION_MAJOR'] == '' && $v_three['Q_START_DATE'] == '' && $v_three['Q_END_DATE'] == ''){
						unset($k_three);
					} else {
						$three[] = $v_three;
					}
				}
			}
			if(!empty($one)){
				$this->modifiedData($one,$userId,1,'');
			}
			if(!empty($two)){
				$this->modifiedData($two,$userId,2,'');
			}
			if(!empty($three)){
				$this->modifiedData($three,$userId,3,'');
			}
			return json_encode(array("code" => 2, "message" => "កំរិតវប្បធម៌ទូទៅ ការបណ្តុះបណ្តាលវិជ្ជាជីវៈនិងការបណ្តុះបណ្តាលបន្តត្រូវបានរក្សាទុក្ខ", "data" => ""));
		} else {
			return json_encode(array("code" => 0, "message" => "", "data" => ""));
		}
	}

	private function modifiedData($data = array(),$userId,$type,$status){
		if($type == 1){
			$data['Q_TYPE'] = $type;
			$data['MEF_OFFICER_ID'] = $userId;
			if($status == 'completed'){
				$data['IS_REGISTER'] = 1;
			} else {
				$data['IS_REGISTER'] = 0;
				/* Update Mef Officer Status */
				$this->logModel->updateMefOfficerIsRegister(0,$userId);
				/* Update Mef Officer Status End */
			}
			$dataUser = DB::table('mef_general_qualifications')->where('MEF_OFFICER_ID',$userId)->where('Q_TYPE',$type)->get();
			if(count($dataUser) == 0){
				DB::table('mef_general_qualifications')->insert($data);
			} else {
				DB::table('mef_general_qualifications')->where('MEF_OFFICER_ID',$userId)->where('Q_TYPE',$type)->update($data);
			}
		} else {
			for($i = 0; $i < count($data); $i++){
				$data[$i]['Q_TYPE'] = $type;
				$data[$i]['MEF_OFFICER_ID'] = $userId;
				if($status == 'completed'){
					$data[$i]['IS_REGISTER'] = 1;
				} else {
					$data[$i]['IS_REGISTER'] = 0;
					/* Update Mef Officer Status */
					$this->logModel->updateMefOfficerIsRegister(0,$userId);
					/* Update Mef Officer Status End */
				}
			}
			DB::table('mef_general_qualifications')->where('MEF_OFFICER_ID',$userId)->where('Q_TYPE',$type)->delete();
			DB::table('mef_general_qualifications')->insert($data);
		}
	}

	public function getAbilityForeignLanguageById($userId){
		$userData = DB::table('mef_foreign_languages')
			->where('MEF_OFFICER_ID', $userId)
			->get();
		if(count($userData) > 0){
			return $userData;
		}
		return $userData = array();
	}
	public function getLanguage(){
		$list = DB::table('mef_language')
			->orderBy('Order', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name,
				"value" =>$row->Id
			);
		}
		return $arrList;
	}

	public function saveAbilityForeignLanguage($data,$userId){
		$language = array();
		foreach($data as $key => $val){
			if(!empty($val)){
				if($val['LANGUAGE'] == '' && $val['RED'] == '' && $val['WRITE'] == '' && $val['SPEAK'] == '' && $val['LISTEN'] == ''){
					if($key > 0){
						unset($key);
					} else {
						$language[] = $val;
						$language[$key]['MEF_OFFICER_ID'] = $userId;
						$language[$key]['IS_REGISTER'] = 1;
					}
				} else {
					unset($val['ID']);
					$language[] = $val;
					$language[$key]['MEF_OFFICER_ID'] = $userId;
					$language[$key]['IS_REGISTER'] = 1;
				}
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
		$this->logModel->officerHistory(6,'mef_foreign_languages',$language,1,"សមត្ថភាពភាសាបរទេស (មធ្យម, ល្អបង្គួរ, ល្អ, ល្អណាស់)",null,$userId);

		DB::table('mef_foreign_languages')->where('MEF_OFFICER_ID', $userId)->delete();
		DB::table('mef_foreign_languages')->insert($language);
		return json_encode(array("code" => 1, "message" => "សមត្ថភាពភាសាបរទេសត្រូវបានរក្សាទុក", "data" => ""));
	}

    public function getOfficerCurrentAddress($id){

       // $data = DB::table('v_current_address')->where('mef_officer_id',$id)->first();
		$data = DB::table("call get_current_address('".$id."'')");
        // dd($data);
        if($data != null){
            return $data;
        }else{
            return $data = array();
        }
    }
    public function getPersonalInfo($officerId){
		$query = DB::table('mef_officer AS of')
			->select('of.Id as id','AVATAR as avatar','sec.Name','info.FULL_NAME_KH','info.FULL_NAME_EN','info.PLACE_OF_BIRTH','info.CURRENT_ADDRESS','info.PHONE_NUMBER_1','info.EMAIL')
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
			->where('MEF_OFFICER_ID', $userId)
			->get();
		$userStatus = DB::table('mef_personal_information')
			->select('MARRIED')
			->where('MEF_OFFICER_ID', $userId)
			->get();
		//dd($userData);
		if(count($userData) > 0){
			$children = DB::table('mef_childrens')
				->where('FAMILY_STATUS_ID',$userData[0]->ID)
				->get();
			$sibling = DB::table('mef_relatives_information')
				->where('FAMILY_STATUS_ID',$userData[0]->ID)
				->get();
			$phone = json_decode($userData[0]->SPOUSE_PHONE_NUMBER);
			$result = array("userData" => $userData[0],"sibling" =>$sibling, "children" =>$children, "phone" =>$phone);
		} else {
			$result = array("userData" => array(array()), "sibling" => array(array()), "children" => array(array()), "phone" => array(array()));
		}
		return array($result,"userStatus" => $userStatus[0]);
	}

	public function saveFamilySituations($data,$userId){
		$spouse = isset($data['COUNT_SPOUSE']) ? $data['COUNT_SPOUSE'] : 0;
		$allAmount = $data['COUNT_PARENT'] + $spouse;
		if($allAmount == 0){
			$this->modifiedFamilyStatus($data,$userId,"completed");
			return json_encode(array("code" => 1, "message" => "ស្ថានភាពគ្រួសារត្រូវបានរក្សាទុក", "data" => ""));
		} elseif($allAmount > 0 && $allAmount < 18) {
			$this->modifiedFamilyStatus($data,$userId,"");
			return json_encode(array("code" => 2, "message" => "ស្ថានភាពគ្រួសារត្រូវបានរក្សាទុក", "data" => ""));
		} else {
			$child = isset($data['COUNT_CHILD']) ? $data['COUNT_CHILD'] : 0;
			$this->modifiedFamilyStatus($data,$userId,"");
			if($child > 0 && $child < 4){
				return json_encode(array("code" => 2, "message" => "ស្ថានភាពគ្រួសារត្រូវបានរក្សាទុក", "data" => ""));
			}
			return json_encode(array("code" => 0, "message" => "ស្ថានភាពគ្រួសារត្រូវបានរក្សាទុក", "data" => ""));
		}
	}

	private function modifiedFamilyStatus($data,$userId,$status){
		$sibling = array();
		$children = array();
		foreach($data['objectFamilySibling'] as $k_sib => $v_sib){
			if(!empty($v_sib)){
				if($v_sib['RELATIVES_NAME_KH'] == '' && $v_sib['RELATIVES_NAME_EN'] == '' && $v_sib['RELATIVES_NAME_GENDER'] == '' && $v_sib['RELATIVES_NAME_DOB'] == '' && $v_sib['RELATIVES_NAME_JOB'] == ''){
					unset($k_sib);
				} else {
					$sibling[] = $v_sib;
				}
			}
		}
		foreach($data['objectFamilyChildren'] as $k_children => $v_child){
			if(!empty($v_child)){
				if($v_child['CHILDRENS_NAME_EN'] == '' && $v_child['CHILDRENS_NAME_KH'] == '' && $v_child['CHILDRENS_NAME_GENDER'] == '' && $v_child['CHILDRENS_NAME_DOB'] == '' && $v_child['CHILDRENS_NAME_JOB'] == '' && $v_child['CHILDRENS_NAME_SPONSOR'] == '' && $v_child['IsExistChild'] != 1){
					unset($k_children);
				} else {
					$children[] = $v_child;
				}
			}
		}
		$family = $data['objectFamily'];
		$familyDate = $data['objectFamilyDate'];
		$phoneNumber = array();
		foreach($data['objectPhoneNumber'] as $key => $value){
			if(!empty($value)){
				$phoneNumber[] = $value;
			} else {
				$phoneNumber[$key] = "";
			}
		}
		$phoneNumber = array(
			'SPOUSE_PHONE_NUMBER' => json_encode($phoneNumber),
		);
		if($status == "completed"){
			$isRegister = array(
				'IS_REGISTER' => 1,
			);
		} else {
			$isRegister = array(
				'IS_REGISTER' => 0,
			);
			/* Update Mef Officer Status */
			$this->logModel->updateMefOfficerIsRegister(0,$userId);
			/* Update Mef Officer Status End */
		}
		$family = array_merge($family,$familyDate,$phoneNumber,$isRegister);
		$officerID = DB::table('mef_family_status')->where('MEF_OFFICER_ID', $userId)->get();
		if(count($sibling) > 0){
			for($i = 0; $i < count($sibling); $i++){
				unset($sibling[$i]['ID']);
				$sibling[$i]['FAMILY_STATUS_ID'] = $officerID[0]->ID;
			}
		}
		if(count($children) > 0){
			for($j = 0; $j < count($children); $j++){
				unset($children[$j]['ID']);
				$children[$j]['FAMILY_STATUS_ID'] = $officerID[0]->ID;
			}
		}
//		dd($family);
		if(count($officerID) > 0){
			/* 	Histrory
				paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
				$formNumber : form number
				$table: table name
				$newFieldArray : new data insert
				$isMultipleRow : Single Row : 0 , Muliple Rows : 1
				$mefFormTitle : Form title
			*/

//			modify by menglay
			$this->logModel->officerHistory(7,'mef_family_status',$family,0,"ស្ថានភាពគ្រួសារ",null,$userId);
			$familyId = DB::table('mef_family_status')->where('MEF_OFFICER_ID',$userId)->update($family);
		} else {
			$family['MEF_OFFICER_ID'] = $userId;
			$familyId = DB::table('mef_family_status')->insert($family);
		}
		// ព័ត៌មានបងប្អូន
		/* 	Histrory
			paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
			$formNumber : form number
			$table: table name
			$newFieldArray : new data insert
			$isMultipleRow : Single Row : 0 , Muliple Rows : 1
			$mefFormTitle : Form title
		*/

//		modify by menglay
//		dd($officerID[0]->Id);
		$this->logModel->officerHistory(7,'mef_relatives_information',$sibling,1,"ស្ថានភាពគ្រួសារ",$officerID[0]->ID,$userId);
		DB::table('mef_relatives_information')->where('FAMILY_STATUS_ID',$officerID[0]->ID)->delete();
		DB::table('mef_relatives_information')->insert($sibling);
		// ព័ត៌មានកូន
		/* 	Histrory
			paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
			$formNumber : form number
			$table: table name
			$newFieldArray : new data insert
			$isMultipleRow : Single Row : 0 , Muliple Rows : 1
			$mefFormTitle : Form title
		*/
//		modify by menglay
		$this->logModel->officerHistory(7,'mef_childrens',$children,1,"ស្ថានភាពគ្រួសារ",$officerID[0]->ID,$userId);
		DB::table('mef_childrens')->where('FAMILY_STATUS_ID',$officerID[0]->ID)->delete();
		DB::table('mef_childrens')->insert($children);
	}

	public function getworkingType(){
		$list = DB::table('mef_working_history_type')
			->orderBy('ID', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->NAME,
				"value" =>$row->ID
			);
		}
		return $arrList;
	}

	public function getPosition(){
		$list = DB::table('mef_position')
			->orderBy('ORDER_NUMBER', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->NAME,
				"value" =>$row->ID
			);
		}
		return $arrList;
	}

	public function getDepartment(){
		$list = DB::table('mef_ministry')
			->orderBy('ID', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->Name.'-'.$row->Abbr,
				"value" =>$row->Id
			);
		}
		return $arrList;
	}

	public function getAwardType(){
		$list = DB::table('mef_award_type')
			->orderBy('ID', 'asc')
			->get();
		$arrList = array(array("text" => "","value" => ""));
		foreach($list as $row){
			$arrList[] = array(
				'text'  =>$row->NAME,
				"value" =>$row->ID
			);
		}
		return $arrList;
	}

	public function saveWokingHistory($data,$userId,$is_register){
		foreach($data as $key=>$val){
			$data[$key]["MEF_OFFICER_ID"] = $userId;
			$data[$key]["IS_REGISTER"] = $is_register;
			if(isset($data[$key]["ID"])){
				unset($data[$key]["ID"]);
			}
			if(
				$val["START_WORKING_DATE"] == "" &&
				$val["END_WORKING_DATE"] == "" &&
				$val["DEPARTMENT"] == "" &&
				$val["INSTITUTION"] == "" &&
				$val["POSITION"] == "" &&
				$val["POSITION_EQUAL_TO"] == ""
			)
			{
				unset($data[$key]);
			}else{
				$data[$key]["START_WORKING_DATE"] == "" ? $data[$key]["START_WORKING_DATE"] = '0000-00-00' : $data[$key]["START_WORKING_DATE"] = $data[$key]["START_WORKING_DATE"];
				$data[$key]["END_WORKING_DATE"] == "" ? $data[$key]["END_WORKING_DATE"] = '0000-00-00' : $data[$key]["END_WORKING_DATE"] = $data[$key]["END_WORKING_DATE"];
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
		/* Update Mef Officer is_register Status */
		if($is_register == 0){
			$this->logModel->updateMefOfficerIsRegister(0,$userId);
		}/* Update Mef Officer is_register Status End */
		$this->logModel->officerHistory(3,'mef_work_history',$data,1,"ប្រវត្តិការងារ",null,$userId);
		DB::table('mef_work_history')->where('MEF_OFFICER_ID', $userId)->delete();
		$affected = DB::table('mef_work_history')
				->where('MEF_OFFICER_ID', $userId)
				->insert($data);
		return $affected;
	}

	public function getWorkHistoryByUserId($userId){
		$array = array();
		$userData = DB::table('mef_work_history')
			->where('MEF_OFFICER_ID', $userId)->orderBy('ID', 'asc')
			->get();
		if(count($userData) > 0){
			$array = $userData;
		}
		return $array;
	}

	public function getWorkHistoryPrivateByUserId($userId){
		$array = array();
		$userData = DB::table('mef_working_history_private')
			->where('MEF_OFFICER_ID', $userId)->orderBy('ID', 'asc')
			->get();
		if(count($userData) > 0){
			$array = $userData;
		}
		return $array;
	}

	public function saveWokingHistoryPrivate($data,$userId){
		foreach($data as $key=>$val){
			$data[$key]["MEF_OFFICER_ID"] = $userId;
			$data[$key]["IS_REGISTER"] = 1;
			if(isset($data[$key]["ID"])){
				unset($data[$key]["ID"]);
			}
			if(
				$val["PRIVATE_START_DATE"] == "" &&
				$val["PRIVATE_END_DATE"] == "" &&
				$val["PRIVATE_DEPARTMENT"] == "" &&
				$val["PRIVATE_ROLE"] == "" &&
				$val["PRIVATE_SKILL"] == ""
			)
			{
				unset($data[$key]);
			}else{
				$data[$key]["PRIVATE_START_DATE"] == "" ? $data[$key]["PRIVATE_START_DATE"] = '0000-00-00' : $data[$key]["PRIVATE_START_DATE"] = $data[$key]["PRIVATE_START_DATE"];
				$data[$key]["PRIVATE_END_DATE"] == "" ? $data[$key]["PRIVATE_END_DATE"] = '0000-00-00' : $data[$key]["PRIVATE_END_DATE"] = $data[$key]["PRIVATE_END_DATE"];
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
		$this->logModel->officerHistory(3,'mef_working_history_private',$data,1,"ប្រវត្តិការងារ",null,$userId);

		DB::table('mef_working_history_private')->where('MEF_OFFICER_ID', $userId)->delete();
		$affected = DB::table('mef_working_history_private')
				->where('MEF_OFFICER_ID', $userId)
				->insert($data);
		return $affected;
	}


	public function getAwardSanctionByUserId($userId){
		$awardSanctionType1 = DB::table('mef_appreciation_awards')
			->where('MEF_OFFICER_ID', $userId)->where('AWARD_TYPE',1)
			->get();
		$awardSanctionType2 = DB::table('mef_appreciation_awards')
			->where('MEF_OFFICER_ID', $userId)->where('AWARD_TYPE',2)
			->get();
		$data	=	array(
				"awardSanctionType1" => $awardSanctionType1,
				"awardSanctionType2" => $awardSanctionType2
		);
		return $data;
	}

	public function saveAwardSanction($data,$userId){
		foreach($data['awardSanctionType1'] as $key=>$val){
			$data['awardSanctionType1'][$key]["MEF_OFFICER_ID"] = $userId;
			$data['awardSanctionType1'][$key]["IS_REGISTER"] = 1;
			$data['awardSanctionType1'][$key]["AWARD_TYPE"] = 1;
			if(isset($data['awardSanctionType1'][$key]["ID"])){
				unset($data['awardSanctionType1'][$key]["ID"]);
			}
			if(
				$val["AWARD_NUMBER"] == "" &&
				$val["AWARD_DATE"] == "" &&
				$val["AWARD_REQUEST_DEPARTMENT"] == "" &&
				$val["AWARD_DESCRIPTION"] == "" &&
				$val["AWARD_KIND"] == ""
			)
			{
				unset($data['awardSanctionType1'][$key]);
			}else{
				$data['awardSanctionType1'][$key]["AWARD_DATE"] == "" ? $data['awardSanctionType1'][$key]["AWARD_DATE"] = '0000-00-00' : $data['awardSanctionType1'][$key]["AWARD_DATE"] = $data['awardSanctionType1'][$key]["AWARD_DATE"];
			}
		}

		if(empty($data['awardSanctionType1'])){
			$data['awardSanctionType1'] = array(
				"AWARD_NUMBER" => "",
				"AWARD_DATE" => '0000-00-00',
				"AWARD_REQUEST_DEPARTMENT" => "",
				"AWARD_DESCRIPTION" => null,
				"AWARD_KIND" => null,
				"AWARD_TYPE" => 1,
				"IS_REGISTER" => 1,
				"MEF_OFFICER_ID" => $userId
			);
		}

		foreach($data['awardSanctionType2'] as $key=>$val){
			$data['awardSanctionType2'][$key]["MEF_OFFICER_ID"] = $userId;
			$data['awardSanctionType2'][$key]["IS_REGISTER"] = 1;
			$data['awardSanctionType2'][$key]["AWARD_TYPE"] = 2;
			if(isset($data['awardSanctionType2'][$key]["ID"])){
				unset($data['awardSanctionType2'][$key]["ID"]);
			}
			if(
				$val["AWARD_NUMBER"] == "" &&
				$val["AWARD_DATE"] == "" &&
				$val["AWARD_REQUEST_DEPARTMENT"] == "" &&
				$val["AWARD_DESCRIPTION"] == "" &&
				$val["AWARD_KIND"] == ""
			)
			{
				unset($data['awardSanctionType2'][$key]);
			}else{
				$data['awardSanctionType2'][$key]["AWARD_DATE"] == "" ? $data['awardSanctionType2'][$key]["AWARD_DATE"] = '0000-00-00' : $data['awardSanctionType2'][$key]["AWARD_DATE"] = $data['awardSanctionType2'][$key]["AWARD_DATE"];
			}
		}
		/* Block History */
		$dataMerge = array_merge($data['awardSanctionType1'], $data['awardSanctionType2']);
		/* 	Histrory
			paratemter $table,$newFieldArray ($this->logModel->officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle))
			$formNumber : form number
			$table: table name
			$newFieldArray : new data insert
			$isMultipleRow : Single Row : 0 , Muliple Rows : 1
			$mefFormTitle : Form title
		*/

//		modify by menglay
		$this->logModel->officerHistory(4,'mef_appreciation_awards',$dataMerge,1,"គ្រឿងឥស្សរិយយស ប័ណ្ណសរសើរ ឬទណ្ឌកម្មវិន័យ",null,$userId);

		/* Block History End */
		// awardSanctionType1
		DB::table('mef_appreciation_awards')->where('MEF_OFFICER_ID', $userId)->where('AWARD_TYPE',1)->delete();
		$affected1 = DB::table('mef_appreciation_awards')
				->where('MEF_OFFICER_ID', $userId)
				->insert($data['awardSanctionType1']);
		// awardSanctionType2
		DB::table('mef_appreciation_awards')->where('MEF_OFFICER_ID', $userId)->where('AWARD_TYPE',2)->delete();
		$affected2 = DB::table('mef_appreciation_awards')
				->where('MEF_OFFICER_ID', $userId)
				->insert($data['awardSanctionType2']);
		return json_encode(array("code" => 1, "message" => "គ្រឿងឥស្សរិយយស ប័ណ្ណសរសើរ ឬទណ្ឌកម្មវិន័យត្រូវបានរក្សាទុក", "data" => ""));

	}

	public function getSecretariatListById($ministryId) {
		$row = DB::table('mef_secretariat')->where('mef_ministry_id', $ministryId)->get();
		if(count($row) > 0){
		 	return $row;
		}
	}

	public function getAutoCompleted($formId,$userId) {
		$data = array();
		$nationality_1 = array();
		$nationality_2 = array();
		$place_1 = array();
		$place_2 = array();
		$place_3 = array();
		$level = array();
		$graduation_major_2 = array();
		$graduation_major_3 = array();
		$f_unit = array();
		$m_unit = array();
		$f_job  = array();
		$m_job  = array();
		$departement_1 = array();
		$departement_2 = array();
		$institution = array();
		$position = array();
		$position_equal = array();
		$private_role = array();
		$private_skill = array();
		$additional_status = array();
		$additional_unit = array();
		$institution_framwork = array();
		$institution_framwork_free = array();
		$spouse_job = array();
		$spouse_unit = array();
		$children_job = array();
		$isMarried = '';

		if($formId == "01" || $formId == "07") {
			$nationality_1 = DB::table('mef_personal_information')
			->select('NATIONALITY_1')
			->where('NATIONALITY_1','!=','')
			->whereNotNull('NATIONALITY_1')
			->groupBy('NATIONALITY_1')
			->get();
			$nationality_2 = DB::table('mef_personal_information')
			->select('NATIONALITY_2')
			->where('NATIONALITY_2','!=','')
			->whereNotNull('NATIONALITY_2')
			->groupBy('NATIONALITY_2')
			->get();
			if ($formId == "07") {
				$f_unit = DB::table('mef_family_status')
					->select('FATHER_UNIT')
					->where('FATHER_UNIT','!=','')
					->whereNotNull('FATHER_UNIT')
					->groupBy('FATHER_UNIT')
					->get();
				$m_unit = DB::table('mef_family_status')
					->select('MOTHER_UNIT')
					->where('MOTHER_UNIT','!=','')
					->whereNotNull('MOTHER_UNIT')
					->groupBy('MOTHER_UNIT')
					->get();
				$f_job = DB::table('mef_family_status')
					->select('FATHER_JOB')
					->where('FATHER_JOB','!=','')
					->whereNotNull('FATHER_JOB')
					->groupBy('FATHER_JOB')
					->get();
				$m_job = DB::table('mef_family_status')
					->select('MOTHER_JOB')
					->where('MOTHER_JOB','!=','')
					->whereNotNull('MOTHER_JOB')
					->groupBy('MOTHER_JOB')
					->get();
				$isMarried = DB::table('mef_personal_information')
					->select('MARRIED')
					->where('MEF_OFFICER_ID',$userId)
					->get();
				$spouse_job = DB::table('mef_family_status')
					->select('SPOUSE_JOB')
					->where('SPOUSE_JOB','!=','')
					->whereNotNull('SPOUSE_JOB')
					->groupBy('SPOUSE_JOB')
					->get();
				$spouse_unit = DB::table('mef_family_status')
					->select('SPOUSE_UNIT')
					->where('SPOUSE_UNIT','!=','')
					->whereNotNull('SPOUSE_UNIT')
					->groupBy('SPOUSE_UNIT')
					->get();
				$children_job = DB::table('mef_childrens')
					->select('CHILDRENS_NAME_JOB')
					->where('CHILDRENS_NAME_JOB','!=','')
					->whereNotNull('CHILDRENS_NAME_JOB')
					->groupBy('CHILDRENS_NAME_JOB')
					->get();
			}
		} elseif($formId == "02") {
		    $additional_status = DB::table('mef_service_status_information')
					->select('ADDITINAL_STATUS')
					->where('ADDITINAL_STATUS','!=','')
					->whereNotNull('ADDITINAL_STATUS')
					->groupBy('ADDITINAL_STATUS')
					->get();
			$additional_unit = DB::table('mef_service_status_information')
					->select('ADDITINAL_UNIT')
					->where('ADDITINAL_UNIT','!=','')
					->whereNotNull('ADDITINAL_UNIT')
					->groupBy('ADDITINAL_UNIT')
					->get();
			$institution_framwork = DB::table('mef_situation_outside_framwork')
					->select('INSTITUTION')
					->where('INSTITUTION','!=','')
					->whereNotNull('INSTITUTION')
					->groupBy('INSTITUTION')
					->get();
			$institution_framwork_free = DB::table('mef_situation_outside_framwork_free')
					->select('INSTITUTION')
					->where('INSTITUTION','!=','')
					->whereNotNull('INSTITUTION')
					->groupBy('INSTITUTION')
					->get();
		} elseif($formId == "03") {
			$departement_1 = DB::table('mef_work_history')
					->select('DEPARTMENT')
					->where('DEPARTMENT','!=','')
					->whereNotNull('DEPARTMENT')
					->groupBy('DEPARTMENT')
					->get();
			$institution = DB::table('mef_work_history')
					->select('INSTITUTION')
					->where('INSTITUTION','!=','')
					->whereNotNull('INSTITUTION')
					->groupBy('INSTITUTION')
					->get();
			$position = DB::table('mef_work_history')
					->select('POSITION')
					->where('POSITION','!=','')
					->whereNotNull('POSITION')
					->groupBy('POSITION')
					->get();
			$position_equal = DB::table('mef_work_history')
					->select('POSITION_EQUAL_TO')
					->where('POSITION_EQUAL_TO','!=','')
					->whereNotNull('POSITION_EQUAL_TO')
					->groupBy('POSITION_EQUAL_TO')
					->get();
			$departement_2 = DB::table('mef_working_history_private')
					->select('PRIVATE_DEPARTMENT')
					->where('PRIVATE_DEPARTMENT','!=','')
					->whereNotNull('PRIVATE_DEPARTMENT')
					->groupBy('PRIVATE_DEPARTMENT')
					->get();
			$private_role = DB::table('mef_working_history_private')
					->select('PRIVATE_ROLE')
					->where('PRIVATE_ROLE','!=','')
					->whereNotNull('PRIVATE_ROLE')
					->groupBy('PRIVATE_ROLE')
					->get();
			$private_skill = DB::table('mef_working_history_private')
					->select('PRIVATE_SKILL')
					->where('PRIVATE_SKILL','!=','')
					->whereNotNull('PRIVATE_SKILL')
					->groupBy('PRIVATE_SKILL')
					->get();
		} elseif($formId == "05") {
			$place_1 = DB::table('mef_general_qualifications')
				->select('PLACE')
				->where('PLACE','!=','')
				->where('Q_TYPE',1)
				->whereNotNull('PLACE')
				->groupBy('PLACE')
				->get();
			$place_2 = DB::table('mef_general_qualifications')
				->select('PLACE')
				->where('PLACE','!=','')
				->where('Q_TYPE',2)
				->whereNotNull('PLACE')
				->groupBy('PLACE')
				->get();
			$place_3 = DB::table('mef_general_qualifications')
				->select('PLACE')
				->where('PLACE','!=','')
				->where('Q_TYPE',3)
				->whereNotNull('PLACE')
				->groupBy('PLACE')
				->get();
			$level = DB::table('mef_general_qualifications')
				->select('LEVEL')
				->where('LEVEL','!=','')
				->where('Q_TYPE',3)
				->whereNotNull('LEVEL')
				->groupBy('LEVEL')
				->get();
			$graduation_major_2 = DB::table('mef_general_qualifications')
				->select('GRADUATION_MAJOR')
				->where('GRADUATION_MAJOR','!=','')
				->where('Q_TYPE',2)
				->whereNotNull('GRADUATION_MAJOR')
				->groupBy('GRADUATION_MAJOR')
				->get();
			$graduation_major_3 = DB::table('mef_general_qualifications')
				->select('GRADUATION_MAJOR')
				->where('GRADUATION_MAJOR','!=','')
				->where('Q_TYPE',3)
				->whereNotNull('GRADUATION_MAJOR')
				->groupBy('GRADUATION_MAJOR')
				->get();
		} else {
			return array();
		}
		$data = array(
		   'NATIONALITY_1'=>$nationality_1,
		   'NATIONALITY_2'=>$nationality_2,
		   'PLACE_1'	  =>$place_1,
		   'PLACE_2'	  =>$place_2,
		   'PLACE_3'	  =>$place_3,
		   'LEVEL'		  =>$level,
		   'GRADUATION_MAJOR_2' =>$graduation_major_2,
		   'GRADUATION_MAJOR_3' =>$graduation_major_3,
		   'FATHER_UNIT'  =>$f_unit,
		   'MOTHER_UNIT'  =>$m_unit,
		   'FATHER_JOB'	  =>$f_job,
		   'MOTHER_JOB'	  =>$m_job,
		   'DEPARTMENT'	  =>$departement_1,
		   'INSTITUTION'  =>$institution,
		   'POSITION'	  =>$position,
		   'POSITION_EQUAL_TO'  =>$position_equal,
		   'PRIVATE_DEPARTMENT' =>$departement_2,
		   'PRIVATE_ROLE'  =>$private_role,
		   'PRIVATE_SKILL' =>$private_skill,
		   'ADDITINAL_STATUS' =>$additional_status,
		   'ADDITINAL_UNIT' =>$additional_unit,
		   'INSTITUTION_FRAMWORK' =>$institution_framwork,
		   'INSTITUTION_FRAMWORK_FREE' =>$institution_framwork_free,
		   'MARRIED' =>$isMarried,
		   'SPOUSE_JOB' =>$spouse_job,
		   'SPOUSE_UNIT' =>$spouse_unit,
		   'CHILDRENS_NAME_JOB' =>$children_job,
		);
		return $data;
	}
}
?>
