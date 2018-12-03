<?php
namespace App\Http\Controllers\BackEnd\GiveRoomAccess;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\RoleModel;
use App\Models\BackEnd\GiveRoomAccess\GiveRoomAccessModel;

class GiveRoomAccessController extends BackendController {

    public function __construct(){
        parent::__construct();
        $this->giveRA = new GiveRoomAccessModel();
        $this->role = new RoleModel();
        $this->userSession = session('sessionUser');
    }
    public function getIndex(){
        $this->data['listRole'] = $this->role->getRoleName();
        $this->data['general_department'] = json_encode($this->giveRA->listAllGeneralDepartment());
        return view('.back-end.giveroomaccess.index')->with($this->data);
    }
    public function postIndex(Request $request){
        return $this->giveRA->getDataGrid($request->all());
    }
    public function postNew(Request $request){
        //assignment value to control
        $this->data['listOfficer'] = json_encode($this->giveRA->getListOfficer());
        $this->data['listRole'] = json_encode($this->giveRA->getMeetingRoom());
        $this->data['listRoleCheck'] = json_encode(array(array('text'=>'', 'value'=>'')));

        return view($this->viewFolder.'.giveroomaccess.new')->with($this->data);
    }
    public function postSave(Request $request){
        return $this->giveRA->postSave($request->all());
    }

    public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->giveRA->postDelete($listId);
    }

    public function postEdit(Request $request){
        //get data to show when update
        $id = intval($request['Id']);

        $this->data['edit_officer_id'] = $id;
//        $this->data['row'] = $this->giveRA->getDataByRowId($id);
        $this->data['listOfficer'] = json_encode($this->giveRA->getListOfficer());
        $this->data['listRole'] = json_encode($this->giveRA->getMeetingRoom());
        $this->data['listRoleCheck'] = json_encode(array(array('text'=>'', 'value'=>'')));
        return view($this->viewFolder.'.giveroomaccess.new')->with($this->data);
    }



    public function postGetDepartmentBySecretariatId(Request $request){
        $secretariatId = intval($request->secretariatId);
        $records = $this->giveRA->getAllDepartmentBySecretariatId($secretariatId);
        return $records;
    }
    public function postGetOfficerByDepartmentId(Request $request){
        $department_id = intval($request->department_id);
        $array = $this->giveRA->getOfficerByDepartmentId($department_id);
        return $array;
    }
    public function postResetPassword(Request $request){
        $this->data['Id'] = intval($request->Id);
        return view($this->viewFolder.'.users.user.reset-password')->with($this->data);
    }
    public function postAjaxSaveResetPassword(Request $request){
        $userId = intval($request->Id);
        return $this->giveRA->ajaxSaveResetPassword($userId,$request['password']);

    }
    //Filter Data Office Of Unit(Ministry,secretary,Department,Office)
    public function postGetUnit(Request $request){
        $mef_officer_id = intval($request->mef_officer_id);
        $result = $this->giveRA->getUnit($mef_officer_id);
        return $result;
    }





    public function postSelectroom(Request $request)
    {
        $officer_id = $request->input('officer_id');
        $data['room_selected'] = $this->giveRA->getRoomSelected($officer_id);
        return response()->json($data);

    }

}