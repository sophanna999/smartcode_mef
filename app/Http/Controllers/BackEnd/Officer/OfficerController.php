<?php 
namespace App\Http\Controllers\BackEnd\Officer;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Officer\OfficerModel;
use App\Models\BackEnd\Report\ReportModel;
use Config;
use Illuminate\Support\Facades\Redirect;
use Mail;
use App\Models\FrontEnd\UpdateInfoModel;
use Illuminate\Support\Facades\Session;
use App\Models\FrontEnd\CheckIsSubmitModel;
use App\Models\FrontEnd\SummaryAllFormModel;
class OfficerController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->officer = new OfficerModel();
        $this->report = new ReportModel();
        $this->userSession = session('sessionUser');
        $this->constant = Config::get('constant');
    }
    public function getIndex()
    {
        // 0=register, 1=submit, 2=complete, 3=waitingApproval
        $data_type = $this->officer->countStatusOfficer();
        $register_row = $data_type[0]->num;
        $submit_row = $data_type[1]->num;
        $complete_row = $data_type[2]->num;
        $waiting_approval_row = $data_type[3]->num;
        $this->data['listStatus'] = $this->officer->getOfficerRegisterStatus();
        $this->data['registered'] = json_decode($this->data['listStatus']);
        $this->data['total_registered'] = $register_row;
        $this->data['total_submitted'] = $submit_row;
        $this->data['total_approved'] = $complete_row;
        $this->data['total_waiting_approval'] = $waiting_approval_row;
        $this->data['general_department'] = json_encode($this->officer->listAllGeneralDepartment());
        return view($this->viewFolder . '.officer.dashboard')->with($this->data);
        //return view('.back-end.officer.index')->with($this->data);
    }
    public function postIndex(Request $request)
    {
        $request->request->add(['this_department_id'=>$this->userSession->mef_department_id,'this_role_id'=>$this->userSession->moef_role_id]);
        return $this->officer->getDataGrid($request->all());
    }
    public function postDelete(Request $request)
    {
        $listId = isset($request['Id']) ? $request['Id'] : '';
        return $this->officer->postDelete($listId);
    }
    public function postNew(Request $request)
    {
        $id = intval($request['Id']);
        $this->data['row'] = $this->officer->getDataByRowId($id);
        $this->data['currentAddress'] = $this->officer->getOfficerCurrentAddress($id);
        return view($this->viewFolder . '.officer.new')->with($this->data);
    }
    public function getEdit($id)
    {
        $this->checkIsSubmitModel = new CheckIsSubmitModel();
        $this->updateInfoModel = new UpdateInfoModel();
        $this->data['constant'] = Config::get('constant');
        $this->data["getMyProfile"] = $this->officer->getMyProfile($id);
        $this->data["last_login_date"] = date('Y-m-d H:i:s');
        $arraySession = array(
            'Id' => '',
            'user_name' => $this->data["getMyProfile"]->full_name_kh,
            'last_login_date' => date('Y-m-d H:i:s'),
            'mef_dep' => $this->data["getMyProfile"]->department_name,
            'generate_id' => $this->data["getMyProfile"]->general_department_name,
            'is_register' => '',
            'is_visited' => '',
            'active' => ''
        );
        Session::put('sessionGuestUser', (object)$arraySession);
        $this->data["indexEdit"] = $id;
        $this->data["checkIsUrlSubmit"] = $this->checkIsSubmitModel->checkIsUrlSubmit($id);
        $this->data["defaultRouteAngularJs"] = '/personal-info';
        $this->data["blgFadeEditClass"] = '';
        $this->data["viewControllerStatus"] = true;
        $this->data['amount'] = count($this->updateInfoModel->getNewNotification($id));
        //dd(session('sessionGuestUser'));
        return view('/front-end.index')->with($this->data);
    }
    // is approval
    public function postSave(Request $request)
    {
        // save notification
        $data_notification['Id'] = $data_approve =$request['Id'] ;
        $data_notification['COMMENT'] = $data_approve = 'ព័ត៌មានប្រវត្តិរូបរបស់អ្នកត្រូវបានអនុម័តរួចរាល់';
        $this->officer->saveNotification($data_notification);
        $data_return = $this->officer->getCommand($request['Id']);
        if($data_return["code"] == 0){
            return Redirect::back()
                ->withInput()
                ->withErrors([
                    'credentials' => $data_return["message"]
                ]);
        }
		$check_email=1;
        $data = $data_return["data"];
        // $check_email = Mail::send($this->viewFolder.'.push-back.push_back_mail', ['data' => $data], function ($m) use ($data){
            // $m->from('smartoffice@mef.gov.kh',trans('trans.project_name'));
            // $m->to($data->email, $data->TO_USER_ID)->subject('ប្រវត្តិរូបមន្ត្រីរាជការ ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ');
            // $m->replyTo('smartoffice@mef.gov.kh',trans('trans.project_name'));
        // });
        //dd($check_email);
        $this->officer->postSave($request->all());
        if($check_email != null){
            // allow approve
            return array("code" => 1, "message" => trans('trans.success'));
        }else{
            return json_encode(array("code" => 0, "message" => "approved was success, but cann't send email: $data->email", "data" => ""));
        }
    }
    public function postSaveEdit(Request $request){
        return $this->officer->savePositionId($request->all());
    }
	public function getDetail($id){
        $approveId = $this->officer->getDataApproveByRowId($id);
        if($approveId != null) {
            $id = $approveId[0]->Id;
            $this->data["idApprove"] = $approveId[0]->Id;
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
        }else{
            $this->data["idApprove"] = null;}
		return view($this->viewFolder.'.officer.detail')->with($this->data);
	}
    public function getPreApproved($id = null){
        if($id == null){
            redirect(base_url($this->constant['secretRoute'].'/officer'));
        }
        $this->data["id"] = $id;
        //Menglay show info current data
        $this->data['row'] = $this->officer->getPersonalInfByOfficerId($id);
        //dd($this->data['row']);
        $this->data['personalInfo'] = $this->officer->getPersonalInfByOfficerId($id);
        $this->data['currentAddress'] = $this->officer->getOfficerCurrentAddress($id);
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
        //Menglay show info witch current approve
        $approveId = $this->officer->getDataApproveByRowId($id);
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
        return view($this->viewFolder.'.officer.pre-approved')->with($this->data);
    }
	public function postFormChange(Request $request){
		$Id = intval($request->Id);
		$records = $this->officer->getOfficerHistoryById($Id);
		if(count($records)){
			$this->data['rows'] = $records;	
		}else{
			$this->data['rows'] = array();	
		}
		return view($this->viewFolder.'.officer.form-change')->with($this->data);
	}
    public function postPushBack(Request $request){
        $this->data['row'] = $this->officer->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.officer.push-back')->with($this->data);
    }
	public function postSavePushBack(Request $request){
	 	$this->officer->saveNotification($request->all());
		$data_return = $this->officer->getCommand($request['Id']);
		//dd($data_return);
        if($data_return["code"] == 0){
            return Redirect::back()
                ->withInput()
                ->withErrors([
                    'credentials' => $data_return["message"]
                ]);
        }
        $data = $data_return["data"];
        Mail::send($this->viewFolder.'.push-back.push_back_mail', ['data' => $data], function ($m) use ($data) {
            $m->from('smartoffice@mef.gov.kh',trans('trans.project_name'));
            $m->to($data->email, $data->TO_USER_ID)->subject('ប្រវត្តិរូបមន្ត្រីរាជការ ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ');
            $m->replyTo('smartoffice@mef.gov.kh',trans('trans.project_name'));
        });
        return array("code" =>1,"message" => trans('trans.success'));
	}
    public function postResetPassword(Request $request){
       $id = intval($request['Id']);
       $this->data['id'] = $id;
       $get_user = $this->officer->getOfficerUserName($id);
       $this->data['user_name'] = $get_user->user_name;
       return view($this->viewFolder.'.officer.reset-password')->with($this->data);
    }
    public function postSaveResetPassword(Request $request){
       $id = intval($request['Id']);
       $data = array('password'=>str_replace("$2y$", "$2a$", bcrypt($request->password)), 'salt'=>$request->password);
       $status = $this->officer->updateOfficerPassword($data,$id);
       if ($status == true){
           return json_encode(array("code" => 1, "message" =>trans('trans.success'), "data" => ""));
       }else{
           return json_encode(array("code" => 0, "message" =>trans('trans.some_thing_went_wrong'), "data" => ""));
       }
   }
    public function geOfficerReport(){
       $this->data['total_mef_officer'] = $this->constant['mefTotalOfficer'];
       $listMinistry = $this->report->getAllMinistry();
       $listGeneralDepartment = $this->report->getAllSecretariatByMinistry();
       $listPosition = $this->report->getPosition();
       $listClassRank = $this->report->getAllClassRank();
       $this->data['listClassRank'] = json_encode($listClassRank);
       $this->data['listPosition'] = json_encode($listPosition);
       $this->data['listMinistry'] = json_encode($listMinistry);
       $this->data['listSecretariat'] = json_encode($listGeneralDepartment);
       $this->data['listDepartment'] = json_encode(array(array('value'=>'','text'=>'')));
       $this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
       return view($this->viewFolder.'.officer.report')->with($this->data);
   }
    public function postTotalOfficerReport(Request $request){
       $mef_secretariat_id = intval($request->mef_secretariat_id);
       $mef_department_id = intval($request->mef_department_id);
       $mef_office_id = intval($request->mef_office_id);
       $mef_position_id = intval($request->mef_position_id);
       $class_rank_id = intval($request->class_rank_id);
       $count_officer = $this->officer->getTotalOfficerView($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id,'','');
       return $count_officer;
   }
    public function postGetDepartmentByGeneralDepartmentId(Request $request){
       $general_department_id = intval($request['general_department_id']);
       return $this->report->getDepartmentBySecretariatId($general_department_id);
   }
    public function postGetOfficeByDepartmentId(Request $request){
       $department_id = intval($request['department_id']);
       return $this->report->getOfficeByDepartmentId($department_id);
   }
    public function geOfficerDashboard(){
        // 0=register, 1=submit, 2=complete, 3=waitingApproval
        $data_type = $this->officer->countStatusOfficer();
        $register_row = $data_type[0]->num;
        $submit_row = $data_type[1]->num;
        $complete_row = $data_type[2]->num;
        $waiting_approval_row = $data_type[3]->num;
        $this->data['listStatus'] = $this->officer->getOfficerRegisterStatus();
        $this->data['registered'] = json_decode($this->data['listStatus']);
        $this->data['total_registered'] = $register_row;
        $this->data['total_submitted'] = $submit_row;
        $this->data['total_approved'] = $complete_row;
        $this->data['total_waiting_approval'] = $waiting_approval_row;
        return view($this->viewFolder.'.officer.dashboard')->with($this->data);
   }
    public function postIsCount(Request $request){
    $id = intval($request['Id']);
    $isCount = intval($request['isCount']);
    return $this->officer->saveIsCount($id,$isCount);
  }
    // Report Excel
    public function postExport(Request $request)
    {
        return $this->officer->postExportExcel($request->all());
    }

}
