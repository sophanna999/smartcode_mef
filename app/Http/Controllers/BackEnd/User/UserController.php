<?php
namespace App\Http\Controllers\BackEnd\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\RoleModel;
use App\Models\BackEnd\User\UserModel;

class UserController extends BackendController {

    public function __construct(){
        parent::__construct();
        $this->user = new UserModel();
        $this->role = new RoleModel();
        $this->userSession = session('sessionUser');
    }
    public function getIndex(){
        $this->data['listRole'] = $this->role->getRoleName();
        $this->data['general_department'] = json_encode($this->user->listAllGeneralDepartment());
        return view('.back-end.users.user.index')->with($this->data);
    }
    public function postIndex(Request $request){
        return $this->user->getDataGrid($request->all());
    }
    public function postNew(Request $request){
        //assignment value to control
        $this->data['listOfficer'] = json_encode($this->user->getListOfficer());
        $this->data['listRole'] = json_encode($this->user->getListRole());
        $this->data['listRoleCheck'] = json_encode(array(array('text'=>'', 'value'=>'')));
        $this->data['listMinistry'] = json_encode(array(array('text'=>'', 'value'=>'')));
	    $this->data['listAllMinistry'] = json_encode($this->user->getlistAllMinistry());
        $this->data['listSecretial'] = json_encode(array(array('text'=>'', 'value'=>'')));
	    $this->data['listAllSecretial'] = json_encode($this->user->getlistAllSecretary());
        $this->data['listDepartment'] = json_encode(array(array('text'=>'', 'value'=>'')));
	    $this->data['listAllDepartment'] = json_encode($this->user->getlistAllDepartment());
        $this->data['listOffice'] = json_encode(array(array('text'=>'', 'value'=>'')));
	    $this->data['listAllOffice'] = json_encode($this->user->getAlllistOffice());
        $this->data['listUser'] = json_encode(array());
        $this->data['listUserCheck'] = json_encode(array());
        return view($this->viewFolder.'.users.user.new')->with($this->data);
    }
    public function postEdit(Request $request){
        //get data to show when update
        //print_r($request->all());exit();
        $id = intval($request['Id']);
        $this->data['row'] = $this->user->getDataByRowId($id);
        //print_r($this->data['row']);exit();
        $listRoleCheck =  explode(',',$this->data['row']->moef_role_id);
        $listUserCheck =  explode(',',$this->data['row']->mef_member_id);
        //assignment value to control
        $this->data['listOfficer'] = json_encode($this->user->getListOfficer());
        $this->data['listRole'] = json_encode($this->user->getListRole());
        $this->data['listRoleCheck'] = json_encode($this->user->getListRoleCheck($listRoleCheck));
        $this->data['listMinistry'] = json_encode($this->user->getlistMinistry($this->data['row']->mef_ministry_id));
	    $this->data['listAllMinistry'] = json_encode($this->user->getlistAllMinistry());
        $this->data['listSecretial'] = json_encode($this->user->getlistSecretary($this->data['row']->mef_general_department_id));
	    $this->data['listAllSecretial'] = json_encode($this->user->getlistAllSecretary());
        $this->data['listDepartment'] = json_encode($this->user->getlistDepartment($this->data['row']->mef_department_id));
	    $this->data['listAllDepartment'] = json_encode($this->user->getlistAllDepartment());
        $this->data['listOffice'] = json_encode($this->user->getlistOffice($this->data['row']->mef_office_id));
	    $this->data['listAllOffice'] = json_encode($this->user->getAlllistOffice());
        $this->data['listUser'] = json_encode($this->user->getListUser($id));
        $this->data['listUserCheck'] = json_encode($this->user->getListUserCheck($listUserCheck));
        //print_r($this->data);exit();
        return view($this->viewFolder.'.users.user.new')->with($this->data);
    }
    public function postSave(Request $request){
        //print_r($request->all());
        return $this->user->postSave($request->all());
    }
    public function postDelete(Request $request){
        //print_r($request->all());exit();
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->user->postDelete($listId);
    }
    public function postUserTaken(Request $request){
        $name = isset($request['user_name']) ? $request['user_name']:'';
        $result = $this->user->cheekUserName($name);
        return json_encode(array('success' =>$result['success']));
    }
    public function getChangePassword(){
        return view($this->viewFolder.'.users.user.change-password')->with($this->data);
    }
    public function postSaveChangePassword(Request $request){
        $modPassword = $this->modChangePassword($request);
        if ($modPassword == false){
            flash()->success(trans('users.incorrectOldPassword'));
            return Redirect::back();
        }else{
            flash()->success(trans('users.passwordChangeSuccess'));
            return $this->user->postSaveChangeUserPassword($this->userSession->id,$request->passwordNew);
        }
    }
    public function modChangePassword($data = ''){
        $row = $this->user->getDataByRowId($this->userSession->id);
        if(isset($row->password)){
            if(Hash::check($data->password,$row->password)){
                //Password successfully save changed
                return true;
            } else {
                //Invalid Old Password
                return false;
            }
        }else{
            //Invalid Old Password
            return false;
        }
    }
    public function postGetDepartmentBySecretariatId(Request $request){
        $secretariatId = intval($request->secretariatId);
        $records = $this->user->getAllDepartmentBySecretariatId($secretariatId);
        return $records;
    }
    public function postGetOfficerByDepartmentId(Request $request){
        $department_id = intval($request->department_id);
        $array = $this->user->getOfficerByDepartmentId($department_id);
        return $array;
    }
    public function postResetPassword(Request $request){
        $this->data['Id'] = intval($request->Id);
        return view($this->viewFolder.'.users.user.reset-password')->with($this->data);
    }
    public function postAjaxSaveResetPassword(Request $request){
        $userId = intval($request->Id);
        return $this->user->ajaxSaveResetPassword($userId,$request['password']);

    }
    //Filter Data Office Of Unit(Ministry,secretary,Department,Office)
    public function postGetUnit(Request $request){
        $mef_officer_id = intval($request->mef_officer_id);
        $result = $this->user->getUnit($mef_officer_id);
        return $result;
    }

}