<?php namespace App\Http\Controllers;
use App\Models\UserAuthorizeModel;
use App\libraries\Tool;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Config;
use DB;
class BackendController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $data = array();
    public function __construct() {
        $this->viewFolder = "back-end";
        $this->userSession = session('sessionUser');
        //$this->Tool = new Tool();
        $this->data['constant'] = Config::get('constant');
        $this->data['tool'] = new Tool();
		$this->constant = Config::get('constant');
        $this->permissionObj = new UserAuthorizeModel();

        //User has not been logged in to system
        if($this->userSession == null){
            Redirect::to('/auth')->send();
        }

        $this->data['segment'] = array(
            'two'       => Request::segment(2),
            'three'     => Request::segment(3),
            'four'      => Request::segment(4),
        );

        //Check permission
        $this->checkUserAuthorize();

    }

    private function checkUserAuthorize(){
        //Get tree menu left & tree menuId
        $statusPermission = $this->permissionObj->userAuthorize();
        $ajaxRequestJson = Request::input('ajaxRequestJson');
        $ajaxRequestHtml = Request::input('ajaxRequestHtml');        
        if($ajaxRequestJson == null && $ajaxRequestHtml == null ){
            $mef_role_id = explode(',',$this->userSession->moef_role_id);
            //print_r($mef_role_id); exit();
            $this->data['treeMenu'] = $this->permissionObj->getTreeMenuLeft($mef_role_id);
            $this->data['treeMenuId'] = $this->permissionObj->getTreeMenuIdByUrl();
        }
        if($statusPermission['code'] == 0){
            if($statusPermission['message'] == 'no-url'){
                if($ajaxRequestJson != null){
                    echo json_encode(array("code" => 0, "message" => $this->data['constant']['pageNotFound'], "data" => "data"));
                    exit();
                }else{
                    if($ajaxRequestHtml != null){
                        exit(view('errors.404')->with($this->data));
                    }else{
                        exit(view('errors.404')->with($this->data));
                    }
                }
            }else{
                if($ajaxRequestJson != null){
                    $this->data['noPermission'] = $this->data['constant']['noPermission'];
                    echo json_encode(array("code" => 0, "message" => $this->data['constant']['noPermission'], "data" => "data"));
                    exit();
                }else{
                    if($ajaxRequestHtml != null){
                        $this->data['noPermission'] = $this->data['constant']['noPermission'];
                        exit(view('errors.no-permission-ajax-html')->with($this->data));
                    }else{
                        $this->data['noPermission'] = $this->data['constant']['noPermission'];
                        exit(view('errors.no-permission-url')->with($this->data));
                    }
                }
            }
        }
    }
	public function getApprovePersonalInfo($officer_id)
	{
		return $db = DB::table('v_mef_officer')->where('mef_officer_id_approve',$officer_id)->where('is_approve',2)->orderBy('user_modify_date','DESC')->first();
	}
	public function postGetOfficeByDepartmentsId(Request $request){
        $departmentId = intval($request->departmentId);
        $this->data['listOffice'] = $this->report->getOfficeByDepartmentId($departmentId);
        return $this->data['listOffice'];
    }
	
}
