<?php
namespace App\Http\Controllers\FrontEnd\BackgroundStaffGovInfo;
use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Models\FrontEnd\BackgroundStaffGovInfoModel;
use App\Models\FrontEnd\PersonalInfoModel;
use App\Models\FrontEnd\UpdateInfoModel;

use Session;

class BackgroundStaffGovInfoController extends FrontendController {

    public function __construct(){
        parent::__construct();
        $this->staffGovModel = new BackgroundStaffGovInfoModel();
		$this->personalInfoModel = new PersonalInfoModel();
		$this->updateInfoModel = new UpdateInfoModel();
    }
	// get Smart Office Module
	public function getSmartOfficeModule(){
		return view($this->viewFolder.'.background-staff-gov-info.smart-module')->with($this->data);
	}
	public function getSmartOfficeGridModule(){
		return view($this->viewFolder.'.background-staff-gov-info.smart-office-grid')->with($this->data);
	}
    public function getIndex(){
        $this->data['general_department'] = json_encode($this->officer->listAllGeneralDepartment());
		return view($this->viewFolder.'.background-staff-gov-info.index')->with($this->data);
    }
	public function getUpdateInfo(){
		return view($this->viewFolder.'.background-staff-gov-info.update-info')->with($this->data);
	}
	public function getGetPersonalInfo($isDirective = false){
    	$this->data['listProvinceJson'] = $this->personalInfoModel->getListProvinceJson();
		// $this->data['Title'] = $this->personalInfoModel->getListTitle();
		if($isDirective == true){
			$this->data["viewControllerStatus"]	=	false;
		}
		return view($this->viewFolder.'.background-staff-gov-info.personal-info')->with($this->data);
    }
	public function postGetPersonalInfoByUserId(Request $request){
		//dd($request['editId']);
		$data = $this->personalInfoModel->getPersonalInfByUserId($request['editId']);
		return json_encode($data);
	}
	public function getGetSituationPublicInfo($isDirective = false){
		if($isDirective == true){
			$this->data["viewControllerStatus"]	=	false;
		}
		$this->data['situationOutSideFrameworkType'] = $this->personalInfoModel->getSituationOutFrameworkType();
		$this->data['listPositions'] = $this->personalInfoModel->getAllPositions();
		$this->data['listDepartments'] = $this->personalInfoModel->getAllDepartment();
		$this->data['listOffices'] = $this->personalInfoModel->getAllOffice();
		$this->data['listClassRanks'] = $this->personalInfoModel->getAllClassRanks();
		$this->data['listDepartmentsOffice'] = $this->personalInfoModel->getAllDepartmentsOffice();
		return view($this->viewFolder.'.background-staff-gov-info.situation-public-info')->with($this->data);
	}
	public function postGetSituationPublicInfoByUserId(Request $request){
		//dd($request->all());
		$data = $this->personalInfoModel->postGetSituationPublicInfoByUserId($request['editId']);
		$firstUnitList = $this->personalInfoModel->getSecretariatListByMinistryId($data->FIRST_MINISTRY);
		$firstDepartmentList = $this->personalInfoModel->getDepartmentListBySecretariatId($data->FIRST_UNIT);
		$firstOfficeList = $this->personalInfoModel->getFirstOfficeListBydepartmentId($data->FIRST_DEPARTMENT);
		$currentDepartmentList = $this->personalInfoModel->getDepartmentListBySecretariatId($data->FIRST_UNIT);
		$currentOfficeList = $this->personalInfoModel->getFirstOfficeListBydepartmentId($data->CURRENT_DEPARTMENT);
		$framework = $this->postGetSituationOutSideFrameWorkByServiceStatusId($request['editId']);
		$frameworkFree = $this->postGetSituationOutSideFrameWorkFreeByServiceStatusId($request['editId']);
		$array = array(
			'main' => $data,
			'framework' => $framework,
			'frameworkFree' => $frameworkFree,
			'firstUnitList' => $firstUnitList,
			'firstDepartmentList' => $firstDepartmentList,
			'firstOfficeList' => $firstOfficeList,
			'currentDepartmentList' => $currentDepartmentList,
			'currentOfficeList' => $currentOfficeList
		);
		return json_encode($array);
	}
	public function postGetSituationOutSideFrameWorkByServiceStatusId($editId){
		//dd($editId);
		$row = $this->personalInfoModel->postGetSituationPublicInfoByUserId($editId);
		$json_data = $this->personalInfoModel->postGetSituationOutSideFrameWorkByServiceStatusId($row->MEF_OFFICER_ID);
		return $json_data;
	}
	public function postGetSituationOutSideFrameWorkFreeByServiceStatusId($editId){
		$row = $this->personalInfoModel->postGetSituationPublicInfoByUserId($editId);
		$json_data = $this->personalInfoModel->postGetSituationOutSideFrameWorkFreeByServiceStatusId($row->MEF_OFFICER_ID);
		return $json_data;
	}
	public function getWorkingHistory($isDirective = false){
		if($isDirective == true){
			$this->data["viewControllerStatus"]	=	false;
		}
		$this->data['listWorkingType'] = $this->staffGovModel->getworkingType();
		$this->data['listPosition'] = $this->staffGovModel->getPosition();
		$this->data['listDepartment'] = $this->staffGovModel->getDepartment();
		return view($this->viewFolder.'.background-staff-gov-info.working-history')->with($this->data);
	}
	public function postGetWorkHistoryById(Request $request){
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->getWorkHistoryByUserId($userId);
		return json_encode($result);
	}
	public function postGetWorkHistoryPrivateById(Request $request){
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->getWorkHistoryPrivateByUserId($userId);
		return json_encode($result);
	}
	public function getAwardSanction($isDirective = false){
		if($isDirective == true){
			$this->data["viewControllerStatus"]	=	false;
		}
		$this->data['listDepartment'] = $this->staffGovModel->getDepartment();
		$this->data['listAwardType'] = $this->staffGovModel->getAwardtype();
		return view($this->viewFolder.'.background-staff-gov-info.award-sanctions')->with($this->data);
	}
	public function postGetAwardSanctionById(Request $request){
		//dd($request->all());
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$data = $this->staffGovModel->getAwardSanctionByUserId($userId);
		return json_encode($data);
	}
	private function getTypeCourse(){
		$result = $this->staffGovModel->getTypeCourse();
		return $result;
	}
	private function getTypeQualifications(){
		$result = $this->staffGovModel->getTypeQualifications();
		return $result;
	}
	public function getGetGeneralKnowledge($isDirective = false){
		if($isDirective == true){
			$this->data["viewControllerStatus"]	=	false;
		}
		$this->data['listTypeCourse'] = $this->getTypeCourse();
		return view($this->viewFolder.'.background-staff-gov-info.general-knowledge')->with($this->data);
	}
	public function postGetGeneralKnowledgeById(Request $request){
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->getGeneralKnowledgeById($userId);
		return json_encode($result);
	}
	public function getAbilityForeignLanguage($isDirective = false){
		if($isDirective == true){
			$this->data["viewControllerStatus"]	=	false;
		}
		$this->data['listTypeQualifications'] = $this->getTypeQualifications();
		$this->data['listLanguage'] = $this->staffGovModel->getLanguage();
		return view($this->viewFolder.'.background-staff-gov-info.ability-foreign')->with($this->data);
	}
	public function postGetAbilityForeignLanguageById(Request $request){
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->getAbilityForeignLanguageById($userId);
		return json_encode($result);
	}
	public function getFamilySituations($isDirective = false){
		//dd('run first');
		if($isDirective == true){
			$this->data["viewControllerStatus"]	=	false;
		}
		return view($this->viewFolder.'.background-staff-gov-info.family-situation')->with($this->data);
	}
	public function postGetFamilySituationsById(Request $request){
		//dd('run second');
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->getFamilySituationsById($userId);
		return json_encode($result);
	}
	public function postFirstUnitList(Request $request){
		$ministryId = $request["Id"];
		$result = $this->personalInfoModel->getSecretariatListByMinistryId($ministryId);
		return json_encode($result);
	}
	public function postFirstDepartmentList(Request $request){
		$secretariatId = $request["Id"];
		$result = $this->personalInfoModel->getDepartmentListBySecretariatId($secretariatId);
		return json_encode($result);
	}
	public function postFirstOfficeList(Request $request){
		$departmentId = $request["Id"];
		$result = $this->personalInfoModel->getFirstOfficeListBydepartmentId($departmentId);
		return json_encode($result);
	}
	public function getReassured(Request $request){
		$user = $request->session()->get('sessionGuestUser');
		$this->data['userInfo'] = $this->getPersonalInfo($user->Id);
		$this->data['currentAddress'] = $this->staffGovModel->getOfficerCurrentAddress($user->Id);//dd($this->data['currentAddress']);
		return view($this->viewFolder.'.background-staff-gov-info.reassured')->with($this->data);
	}
	private function getPersonalInfo($userId){
		//print_r($userId);exit();
		$result = $this->staffGovModel->getPersonalInfo($userId);
		return $result;
	}
	
	public function getGeneralKnowledge($isDirective = false){
		if($isDirective == true){
			$this->data["viewControllerStatus"]	=	false;
		}
		$this->data['listDegree'] = $this->getDegree();
		$this->data['listSkill'] = $this->getSkill();
		$this->data['listUnderDegree'] = $this->getUnderDegree();
		$this->data['listUnderSkill'] = $this->getUnderSkill();
		return view($this->viewFolder.'.background-staff-gov-info.general-knowledge')->with($this->data);
	}
	private function getDegree(){
		return $this->staffGovModel->getDegree();
	}
	private function getSkill(){
		return $this->staffGovModel->getSkill();
	}
	private function getUnderDegree(){
		return $this->staffGovModel->getUnderDegree();
	}
	private function getUnderSkill(){
		return $this->staffGovModel->getUnderSkill();
	}
	public function postGetIsSubmitAllForm(){
		return $this->checkIsSubmitModel->getIsSubmitAllForm();
	}
	public function getNewNotification(){
		return view($this->viewFolder.'.background-staff-gov-info.new-notification');
	}
	public function postNewNotification(){
		$data_not = $this->updateInfoModel->getAllNotification();
		return json_encode($data_not,JSON_UNESCAPED_UNICODE);
	}
	public function postAmountNotification(){
		$amount = $this->updateInfoModel->getNewNotification();
		$newAmount = count($amount);
		return $newAmount;
	}
	// get Auto Completed Data
	/*public function postGetAutoCompleted(Request $request){
		$user = $request->session()->get('sessionGuestUser');
		$formId =$request->formId;
		$data = $this->staffGovModel->getAutoCompleted($formId,$user->Id);
		return $data;
	}*/
	public function postGetDistrict(Request $request){
		$provinceId = $request->Id ? $request->Id : 0;
		$data_not = $this->personalInfoModel->getDistrict($provinceId);
		return json_encode($data_not,JSON_UNESCAPED_UNICODE);
	}
	public function postGetCommune(Request $request){
		$districtId = $request->Id ? $request->Id : 0;
		$data_not = $this->personalInfoModel->getCommune($districtId);
		return json_encode($data_not,JSON_UNESCAPED_UNICODE);
	}
	public function postGetVillages(Request $request){
		$communeId = $request->Id ? $request->Id : 0;
		$data_not = $this->personalInfoModel->getVillages($communeId);
		return json_encode($data_not,JSON_UNESCAPED_UNICODE);
	}
	/*Block Save and Update senven form*/
	public function postSavePersonalInfo(Request $request){
		//dd($request->all());
		return $this->personalInfoModel->postSavePersonalInfo($request->all());
	}
	public function postSaveSituationPublicInfo(Request $request){
		//dd($request['editId']);
		$boolean = $this->personalInfoModel->postSaveSituationPublicInfo($request->all());
		$row = $this->personalInfoModel->postGetSituationPublicInfoByUserId($request['editId']);
		$data = $request->data;
		$array_1 = $data["framework"];
		$array_2 = $data["frameworkFree"];
		$this->personalInfoModel->postSaveSituationOutSideFrameWorkByServiceStatusId($row->MEF_OFFICER_ID,$array_1,$request['editId']);//ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម
		$this->personalInfoModel->postSaveSituationOutSideFrameWorkFreeByServiceStatusId($row->MEF_OFFICER_ID,$array_2,$request['editId']);//ស្ថានភាពស្ថិតនៅភាពទំនេរគ្មានបៀវត្ស
		return json_encode(array('code'=>1,'message'=>'ព័ត៌មានស្ថានភាពមុខងារត្រូវបានរក្សាទុក'));
	}
	public function postWorkingHistory(Request $request){
		//dd($request->all());
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->saveWokingHistory($request['data']['workHistoryObj'],$userId,$request['IS_REGISTER']);
		$resultPrivate = $this->staffGovModel->saveWokingHistoryPrivate($request['data']['workHistoryObjPrivate'],$userId);
		if(($result == true or $resultPrivate == true) or($result == true and $resultPrivate == true) ){
			return json_encode(array('code'=>1,'message'=>'ប្រវត្តិការងារត្រូវបានរក្សាទុក'));
		}
	}
	public function postAwardSanctions(Request $request){
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->saveAwardSanction($request['data'],$userId);
		return $result;
	}
	public function postGeneralKnowledge(Request $request){
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->saveGeneralKnowledge($request['data'],$userId);
		return $result;
	}
	public function postAbilityForeign(Request $request){
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->saveAbilityForeignLanguage($request['data'],$userId);
		return $result;
	}
	public function postFamilySituations(Request $request){
		//dd('run third');
		$userId = empty($this->userGuestSession->Id) ? $request['editId'] : $this->userGuestSession->Id;
		$result = $this->staffGovModel->saveFamilySituations($request['data'],$userId);
		return $result;
	}
	/*End Block Save and Update senven form*/
	// All Form
	public function getAllForm(){
		$this->data['situationOutSideFrameworkType'] = $this->personalInfoModel->getSituationOutFrameworkType();
		$this->data['listPositions'] = $this->personalInfoModel->getAllPositions();
		$this->data['listDepartments'] = $this->personalInfoModel->getAllDepartment();
		$this->data['listOffices'] = $this->personalInfoModel->getAllOffice();
		$this->data['listClassRanks'] = $this->personalInfoModel->getAllClassRanks();
		$this->data['listDepartmentsOffice'] = $this->personalInfoModel->getAllDepartmentsOffice();
		$this->data['listWorkingType'] = $this->staffGovModel->getworkingType();
		$this->data['listPosition'] = $this->staffGovModel->getPosition();
		$this->data['listDepartment'] = $this->staffGovModel->getDepartment();
		$this->data['listTypeQualifications'] = $this->getTypeQualifications();
		$this->data['listLanguage'] = $this->staffGovModel->getLanguage();
		$this->data["blgFadeEditClass"]	=	'blg-fade-edit';
		$this->data['listDegree'] = $this->getDegree();
		$this->data['listSkill'] = $this->getSkill();
		$this->data['listUnderDegree'] = $this->getUnderDegree();
		$this->data['listUnderSkill'] = $this->getUnderSkill();
		$this->data["viewControllerStatus"]	=	false;
		return view($this->viewFolder.'.background-staff-gov-info.all-form')->with($this->data);
    }
}
