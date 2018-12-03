<?php 
namespace App\Http\Controllers\BackEnd\PushBack;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Models\BackEnd\Officer\OfficerModel;
use Illuminate\Support\Facades\Redirect;
use Config;
use Mail;
class PushBackController extends BackendController {
	
	public function __construct(){
		parent::__construct();
		$this->officer = new OfficerModel();
		$this->userSession = session('sessionUser');
	}
    public function getIndex(){ 
		return view('.back-end.push-back.index')->with($this->data);
    }
	public function postIndex(Request $request){
        $request->request->add(['mef_member_id'=>$this->userSession->mef_member_id,'this_role_id'=>$this->userSession->moef_role_id]); //add value to array request
       return $this->officer->getDataPushBack($request->all());
    }
    public function postNew(Request $request){
        
    	$this->data['listOfficer'] = $this->officer->getOfficer();
    	$this->data['listNotification'] = $this->officer->getnotificationdata($request['Id']);
        return view($this->viewFolder.'.push-back.new')->with($this->data);
    }
    public function postView(Request $request){
    	$this->data['listOfficer'] = $this->officer->getOfficer();
    	$this->data['listNotification'] = $this->officer->getnotificationdata($request['Id']);
        return view($this->viewFolder.'.push-back.new')->with($this->data);
    }
    public function postSavePushBack(Request $request){

	    $this->officer->saveNewNotification($request->all());
        $data_return = $this->officer->getCommand($request['officer']);
        
        if($data_return["code"] == 0){
            return Redirect::back()
                ->withInput()
                ->withErrors([
                    'credentials' => $data_return["message"]
                ]);
        }
        $data = $data_return["data"];
        Mail::send($this->viewFolder.'.push-back.push_back_mail', ['data' => $data], function ($m) use ($data) {
            $m->from('kong_marinmoliva@mef.gov.kh','Push Back');
            $m->to($data->email, $data->TO_USER_ID)->subject('ប្រវត្តិរូបមន្ត្រីរាជការ ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ');
            $m->replyTo('kong_marinmoliva@mef.gov.kh','Push Back');
        });
        return array("code" =>1,"message" => trans('trans.success'));
	}
}
