<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Config;
use App\Models\FrontEnd\CheckIsSubmitModel;
use App\Models\FrontEnd\SummaryAllFormModel;
use App\Models\FrontEnd\UpdateInfoModel;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller {

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
    function __construct() {
        $this->viewFolder = "front-end";
        $this->data['constant'] = Config::get('constant');
		$this->userGuestSession = session('sessionGuestUser'); //dd($this->userGuestSession);
		//dd(session('sessionGuestUser'));
		$this->updateInfoModel = new UpdateInfoModel();
		
		/* USER HAS NO SESSION */
        if($this->userGuestSession == null){
            Redirect::to('/login')->send();
        }

        /* Left content */
		$this->data["getMyProfile"] = $this->getMyProfile($this->userGuestSession->Id);
		$this->data["last_login_date"] = date('g:i A',strtotime($this->userGuestSession->last_login_date));

		$this->checkIsSubmitModel	=	new CheckIsSubmitModel();
		$this->allFormModel = new SummaryAllFormModel();
		$this->data["checkIsUrlSubmit"]	=	$this->checkIsSubmitModel->checkIsUrlSubmit();	
		$this->data["defaultRouteAngularJs"]	= '';
		$this->data["blgFadeEditClass"]	=	'';
		$this->data["viewControllerStatus"]	=	true;
    }
	public function getIndex(){

		$dataViewLayout	=	'.index';
		$checkIsRegisterStatus = $this->checkIsSubmitModel->checkIsRegisterStatus();
		//Menglay: If user isn't register goto logout else to continue
		if($checkIsRegisterStatus == false){
			return redirect('/register/guest-logout');
		}
		$is_register = $checkIsRegisterStatus["is_register"];
		$is_visited = $checkIsRegisterStatus["is_visited"];
//		print_r($is_register.'-'.$is_visited); exit();
//		Menglay: if condition is not ture that maean to all-from update (7-from)
		//dd($is_register);
		if($is_register == 0 || $is_register == 1){
			if($is_visited == 0){
				Session::flash('is_visited_first', true);
				$this->checkIsSubmitModel->updateIsVisitedFirst();
			}
			$this->data["defaultRouteAngularJs"]='/personal-info';
			$this->viewFolder = "front-end";
		}else{
			$this->data["defaultRouteAngularJs"]='/smart-office';
			$dataViewLayout	='.smart-office';
		}
		$amount = $this->updateInfoModel->getNewNotification();
		$this->data['amount'] = count($amount);
//		print_r($this->viewFolder.$dataViewLayout.'--'.$this->data['amount']); exit();
//		return view('/front-end.index')->with($this->data);
//		dd($this->data["defaultRouteAngularJs"]);
		return view($this->viewFolder.$dataViewLayout)->with($this->data);
	}
	public function getAllForm(){
		$this->data["defaultRouteAngularJs"] = '/all-form';
		return view($this->viewFolder.'.all-form')->with($this->data);
	}

	private function getMyProfile($officer_id){
	    $array = array(
	        'avatar'                    =>'',
	        'full_name_kh'              =>'',
            'position'                  =>'',
            'department_name'           =>'',
            'general_department_name'   =>''
        );
        $list = DB::table('v_mef_officer')
            ->where('Id',$officer_id)
            ->select('full_name_kh','position','department_name','general_department_name','avatar')
            ->first();
        if ($list){
            $array = $list;
        }
        return (object)$array;
	}
	
	public function getApprovePersonalInfo($officer_id)
	{
		return $db = DB::table('v_mef_officer')
			->where('Id',$officer_id)
			// ->where('mef_officer_id_approve',$officer_id)
			->whereNull('approve')
			// ->where('is_approve',2)
			->orderBy('user_modify_date','DESC')->first();
	}
}
