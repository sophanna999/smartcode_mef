<?php
namespace App\Http\Controllers\FrontEnd\BackgroundStaffGovInfo;
use App\Http\Controllers\FrontendController;
use App\Models\FrontEnd\RegisterModel;
use Illuminate\Http\Request;
use App\Models\FrontEnd\SummaryAllFormModel;
use App\Models\BackEnd\Officer\OfficerModel;
use Session;


class SummaryAllFormController extends FrontendController {
    public function __construct(){
        parent::__construct();
        $this->officer = new OfficerModel();
		$this->summaryAllForm = new SummaryAllFormModel();
        $this->register = new RegisterModel();
    }

    public function getIndex(){
        $this->data['tab']=1;
		$officer_id = $this->userGuestSession->Id;
        $personal_info = $this->summaryAllForm->getPersonalInfoByOfficerId($officer_id);
        $service_status_info = $this->summaryAllForm->getServiceStatusInfoByOfficerId($officer_id);
        $work_history = $this->summaryAllForm->getWorkHistoryByOfficerId($officer_id);
        $appreciation_award = $this->summaryAllForm->getAwardSanctionByOfficerId($officer_id,1);
		$general_qualification = $this->summaryAllForm->getGeneralQualificationByOfficerId($officer_id,1);//dd($general_qualification);
		$family_situation = $this->summaryAllForm->getFamilySituationByOfficerId($officer_id);
		$ability_foreign_language = $this->summaryAllForm->getAbilityForiegnLanguageByOfficerId($officer_id);

		//Tab edit
		$this->data['personal_info'] = $personal_info;
		$this->data['service_status_info'] = $service_status_info;
		$this->data['work_history'] = $work_history;
		$this->data['appreciation_award'] = $appreciation_award;
		$this->data['general_qualification'] = $general_qualification;
		$this->data['family_situation'] = $family_situation;
		$this->data['ability_foreign_language'] = $ability_foreign_language;
		//Tab approve
        $approveId = $this->officer->getDataApproveByRowId($officer_id);
        if($approveId != null){
            $this->data["idApprove"] = $approveId[0]->Id;
            $this->data["rowApprove"]= $this->officer->getPersonalInfByOfficerId($approveId[0]->Id);
            $this->data['currentAddressApprove'] = $this->officer->getOfficerCurrentAddress($approveId[0]->Id);
            $this->data['personalInfoApprove'] = $this->officer->getPersonalInfByOfficerId($approveId[0]->Id);
            $this->data['serviceStatusInfoIdApprove'] = $this->officer->getSeviceStatusInfByOfficerId($approveId[0]->Id);
            $this->data['serviceStatusCurrentIdApprove'] = $this->officer->getSeviceStatusCurrentByOfficerId($approveId[0]->Id);
            $this->data['serviceStatusAdditioanlIdApprove'] = $this->officer->getSeviceStatusAdditonalByOfficerId($approveId[0]->Id);
            $this->data['situationOutsideIdApprove'] = $this->officer->getSituationOutSideFramworkByOfficerId($approveId[0]->Id);
            $this->data['situationFreeIdApprove'] = $this->officer->getSituationOutSideFreeByOfficerId($approveId[0]->Id);
            $this->data['familyStatusIdApprove'] = $this->officer->getFamilyStatusByOfficerId($approveId[0]->Id);
            $this->data['workingHistoryIdApprove'] = $this->officer->getWorkingHistoryByOfficerId($approveId[0]->Id);
            $this->data['workingHistoryPrivateIdApprove'] = $this->officer->getWorkingHistoryPrivateByOfficerId($approveId[0]->Id);
            $this->data['AppreciationAwardsIdApprove'] = $this->officer->getAppreciationAwardsByOfficerId($approveId[0]->Id);
            $this->data['appreciationSanctionIdApprove'] = $this->officer->getAppreciationSanctionByOfficerId($approveId[0]->Id);
            $this->data['generalQualificationsIdApprove'] = $this->officer->getGeneralQualificationsByOfficerId($approveId[0]->Id);
            $this->data['generalQualificationsSkillIdApprove'] = $this->officer->getGeneralQualificationsSkillByOfficerId($approveId[0]->Id);
            $this->data['generalQualificationsTrainingIdApprove'] = $this->officer->getGeneralQualificationsTrainingOfficerId($approveId[0]->Id);
            $this->data['foreignLanguagesOfficerIdApprove'] = $this->officer->getForeignLanguagesOfficerId($approveId[0]->Id);
            $this->data['relativesInformationIdApprove'] = $this->officer->getRelativesInformationOfficerId($approveId[0]->Id);
            $this->data['childrenIdApprove'] = $this->officer->getChildrenOfficerId($approveId[0]->Id);
            $this->data['phoneNumberApprove'] = $this->officer->getPhoneNumber($approveId[0]->Id);
        }else{
            $this->data["idApprove"] = null;
        }
        return view($this->viewFolder.'.background-staff-gov-info.all-form')->with($this->data);
    }

    public function getDetail(){
        $approveId = $this->officer->getDataApproveByRowId($this->userGuestSession->Id);
        if($approveId != null) {
            $id = $approveId[0]->Id;
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
            $this->data['currentAddress'] = $this->officer->getOfficerCurrentAddress($id);
            $this->data['phoneNumber'] = $this->officer->getPhoneNumber($id);
        }
        return view($this->viewFolder.'.background-staff-gov-info.detail')->with($this->data);
    }

	public function getEditPersonalInfo()
    {
        $this->data['tab']=1;
        return view($this->viewFolder.'.background-staff-gov-info.all-form')->with($this->data);
    }

    public function getPersonalReport()
	{
        $this->data['tab']=3;
        $listMinistry = $this->register->getAllMinistry();
        $this->data['listMinistry'] = json_encode($listMinistry);
        $this->data['listSecretariat'] = json_encode($this->register->getAllSecretariatByMinistry(76));
        $this->data['listDepartment'] = json_encode($this->register->getDepartmentBySecretariatId(2));
        $this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
        return view($this->viewFolder.'.background-staff-gov-info.all-form')->with($this->data);
	}

    public function getPrintPersonalInfo()
    {
        $this->data['tab']=2;
        $approveId = $this->officer->getDataApproveByRowId($this->userGuestSession->Id);
        $officer_id = $this->userGuestSession->Id;
        $personal_info = $this->summaryAllForm->getPersonalInfoByOfficerId($officer_id);
        $service_status_info = $this->summaryAllForm->getServiceStatusInfoByOfficerId($officer_id);
        $work_history = $this->summaryAllForm->getWorkHistoryByOfficerId($officer_id);
        $appreciation_award = $this->summaryAllForm->getAwardSanctionByOfficerId($officer_id,1);
		$general_qualification = $this->summaryAllForm->getGeneralQualificationByOfficerId($officer_id,1);//dd($general_qualification);
		$family_situation = $this->summaryAllForm->getFamilySituationByOfficerId($officer_id);
		$ability_foreign_language = $this->summaryAllForm->getAbilityForiegnLanguageByOfficerId($officer_id);

		//Tab edit
		$this->data['personal_info'] = $personal_info;
		$this->data['service_status_info'] = $service_status_info;
		$this->data['work_history'] = $work_history;
		$this->data['appreciation_award'] = $appreciation_award;
		$this->data['general_qualification'] = $general_qualification;
		$this->data['family_situation'] = $family_situation;
		$this->data['ability_foreign_language'] = $ability_foreign_language;
		//Tab approve
        $approveId = $this->officer->getDataApproveByRowId($officer_id);
        if($approveId != null){
            $this->data["idApprove"] = $approveId[0]->Id;
            $this->data["rowApprove"]= $this->officer->getPersonalInfByOfficerId($approveId[0]->Id);
            $this->data['currentAddressApprove'] = $this->officer->getOfficerCurrentAddress($approveId[0]->Id);
            $this->data['personalInfoApprove'] = $this->officer->getPersonalInfByOfficerId($approveId[0]->Id);
            $this->data['serviceStatusInfoIdApprove'] = $this->officer->getSeviceStatusInfByOfficerId($approveId[0]->Id);
            $this->data['serviceStatusCurrentIdApprove'] = $this->officer->getSeviceStatusCurrentByOfficerId($approveId[0]->Id);
            $this->data['serviceStatusAdditioanlIdApprove'] = $this->officer->getSeviceStatusAdditonalByOfficerId($approveId[0]->Id);
            $this->data['situationOutsideIdApprove'] = $this->officer->getSituationOutSideFramworkByOfficerId($approveId[0]->Id);
            $this->data['situationFreeIdApprove'] = $this->officer->getSituationOutSideFreeByOfficerId($approveId[0]->Id);
            $this->data['familyStatusIdApprove'] = $this->officer->getFamilyStatusByOfficerId($approveId[0]->Id);
            $this->data['workingHistoryIdApprove'] = $this->officer->getWorkingHistoryByOfficerId($approveId[0]->Id);
            $this->data['workingHistoryPrivateIdApprove'] = $this->officer->getWorkingHistoryPrivateByOfficerId($approveId[0]->Id);
            $this->data['AppreciationAwardsIdApprove'] = $this->officer->getAppreciationAwardsByOfficerId($approveId[0]->Id);
            $this->data['appreciationSanctionIdApprove'] = $this->officer->getAppreciationSanctionByOfficerId($approveId[0]->Id);
            $this->data['generalQualificationsIdApprove'] = $this->officer->getGeneralQualificationsByOfficerId($approveId[0]->Id);
            $this->data['generalQualificationsSkillIdApprove'] = $this->officer->getGeneralQualificationsSkillByOfficerId($approveId[0]->Id);
            $this->data['generalQualificationsTrainingIdApprove'] = $this->officer->getGeneralQualificationsTrainingOfficerId($approveId[0]->Id);
            $this->data['foreignLanguagesOfficerIdApprove'] = $this->officer->getForeignLanguagesOfficerId($approveId[0]->Id);
            $this->data['relativesInformationIdApprove'] = $this->officer->getRelativesInformationOfficerId($approveId[0]->Id);
            $this->data['childrenIdApprove'] = $this->officer->getChildrenOfficerId($approveId[0]->Id);
            $this->data['phoneNumberApprove'] = $this->officer->getPhoneNumber($approveId[0]->Id);
        }else{
            $this->data["idApprove"] = null;
        }
        return view($this->viewFolder.'.background-staff-gov-info.all-form')->with($this->data);
    }

    public function postSelectReport(Request $request)
    {
        $report_type = $request->report_type;
        $start_date = date("Y-m-d", strtotime(trim(str_replace('/','-',$request->start_date))) );
        $end_date = date("Y-m-d", strtotime(trim(str_replace('/','-',$request->end_date))) );
        $officerDateIn = date("Y", strtotime(trim(str_replace('/','-',$request->officerDateIn))));
        $report_view = null;
        $this->data['test']=3;

        $mef_ministry_id = $request->mef_ministry_id != null ?  $request->mef_ministry_id : "'%'";
        $department_id = $request->department_id != null ?  $request->department_id : "'%'";
        $mef_secretariat_id = $request->mef_secretariat_id != null ?  $request->mef_secretariat_id : "'%'";
        $mef_office_id = $request->mef_office_id != null ?  $request->mef_office_id : "'%'";


        if($report_type == 1){
            $this->data['report_data'] = $this->summaryAllForm->getDegreeReport($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id);
            $report_view =  "degree_report";
        }elseif($report_type == 2){
            $this->data['report_data'] = $this->summaryAllForm->getGenderReport($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id);
            $report_view = "officer_report";
        }elseif($report_type == 3){
            $this->data['report_data'] = $this->summaryAllForm->getOfficerReportDetail($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id,$start_date,$end_date,$officerDateIn);
            $report_view = "officer_detail_report";
        }elseif($report_type == 4){
            $report_view = "table_degree_officer";
        }


        return view($this->viewFolder.'.background-staff-gov-info.'.$report_view)->with($this->data);
    }
}
