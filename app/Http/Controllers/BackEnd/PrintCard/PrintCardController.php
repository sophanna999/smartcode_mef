<?php 
namespace App\Http\Controllers\BackEnd\PrintCard;

use DB;
use Input;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Models\BackEnd\Officer\OfficerModel;
use App\Models\BackEnd\PrintCard\PrintCard;
use Illuminate\Support\Facades\Redirect;
use Config;
use Mail;
class PrintCardController extends BackendController {
	
	public function __construct(){
		parent::__construct();
		$this->officer = new OfficerModel();
		$this->userSession = session('sessionUser');
	}
	public function getIndex(){
		$this->data['listStatus'] = $this->officer->getOfficerRegisterStatus();
		$this->data['registered'] = json_decode($this->data['listStatus']);
        $this->data['general_department'] = json_encode($this->officer->listAllGeneralDepartment());
		return view('.back-end.printCard.index')->with($this->data);
    }
    public function postIndex(Request $request){
        $request->request->add(['this_department_id'=>$this->userSession->mef_department_id,'this_role_id'=>$this->userSession->moef_role_id]);
        return $this->officer->getDataGrid($request->all());
    }
    public function getPrintCard($Id='')
    {
    	# code...
    	$this->data['user'] = DB::table('v_mef_officer')
                    ->select(
                        'Id',
                        'full_name_en',
                        'full_name_kh',
                        'avatar',
                        'email',
                        'gender',
                        'phone_number_1',
                        'general_department_name',
                        'department_name',
                        'position',
                        'is_register',
                        'register_date'
                    )
                    ->where('Id',$Id)
                	->first();
    	return view($this->viewFolder.'.printCard.detail')->with($this->data);
    }

}
