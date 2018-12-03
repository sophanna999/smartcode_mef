<?php 
namespace App\Http\Controllers\FrontEnd\Register;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrontEnd\RegisterModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Mail;
use File;
class RegisterController extends Controller {
	public $data = array();
    public function __construct(){
        $this->viewFolder = 'front-end';
		$this->register = new RegisterModel();
    }
	public function getIndex(){
		$this->data["defaultRouteAngularJs"] = "";
		$this->data["checkIsUrlSubmit"] = array();
		$this->data["login_page"] = true;

		return view($this->viewFolder.'.register.smart-guest-login')->with($this->data);
	}
	public function getGetRegister(){
		$listMinistry = $this->register->getAllMinistry();
		$this->data['listMinistry'] = json_encode($listMinistry);
		$this->data['listSecretariat'] = json_encode(array(array('value'=>'','text'=>'')));
		$this->data['listDepartment'] = json_encode(array(array('value'=>'','text'=>'')));
		$this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
		return view($this->viewFolder.'.register.register')->with($this->data);
	}
	public function postDoRegister(Request $request){
        $user_name = isset($request['USER_NAME']) ? $request['USER_NAME']:'';
		$email = isset($request['EMAIL']) ? $request['EMAIL']:'';
        $user_exist = $this->register->postUserAvailable($user_name);
		$email_exist = $this->register->verifyEmail($email);
		$email_exist = json_decode($email_exist);
		$data = array(
		    'user_name'         =>$user_name,
            'password'          =>$request['USER_PASSWORD'],
            'confirmation_code' =>$request['confirmation_code'],
            'full_name_kh'      =>$request['FULL_NAME_KH']
        );
		if($user_exist['success'] == true){
			/*User taken*/
			return Redirect::back()
					->withInput()
					->withErrors(['credentials' =>trans('users.user_token')]);
		}else{
		    /* Create folder in officer folder */
            $path = public_path().'/files/officer/' . $user_name;
            File::makeDirectory($path, $mode = 0777, true, true);
        }
		if($email_exist->code == 0){
			/* Email taken*/
			return Redirect::back()
					->withInput()
					->withErrors(['credentials' =>trans('register.email_taken')]);
		}
		
		/* 
		 Username & email available, we send confirmation code to
		email address in order to confirm account
		*/

        return $this->postSendConfirmationCode($data, $request->all());
	}
	public function getActivate($confirmation_code){
        $data_array = array(
	        'active'            =>1,
            'confirmation_code' =>NULL
        );
	    $data = $this->register->activeOfficerByConfirmationCode($confirmation_code,$data_array);
        if ($data){
            $message = trans('officer.your_account_success_active');
            flash($message, 'success');
        }else{
            $message = trans('officer.your_account_already_active');
            flash($message, 'success');
        }
        return redirect('/login');
    }
	public function postSendConfirmationCode($data, $input){
        Mail::send($this->viewFolder.'.register.confirm-account-mail', $data, function($message) use ($input) {
            $message->from('smartoffice@mef.gov.kh', trans('trans.project_name'));
            $message->to($input['EMAIL'], $input['FULL_NAME_KH'])->subject(trans('officer.account_confirmation'));
        });
        $message = trans('officer.open_your_email');
        flash($message, 'success');
       	return $this->register->doRegister($input);
    }

	public function postVerifyEmail(Request $request){
		return $this->register->verifyEmail($request['email']);
	}
	public function postVerifyCaptcha(Request $request){
		$rules = ['captcha' => 'required|captcha'];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()){
			return 'false';
		} else {
			return 'true'; 
		}
	}
	public function postUserAvailable(Request $request){
		$name = isset($request['user_name']) ? $request['user_name']:'';
        $result = $this->register->postUserAvailable($name);
        return json_encode(array('success' =>$result['success']));
	}
	public function postGetSecretaryByMinistryId(Request $request){
		$ministryId = intval($request->ministryId);
		$this->data['listSecretariat'] = $this->register->getAllSecretariatByMinistry($ministryId);
		return $this->data['listSecretariat'];
	}
	public function postGetDepartmentBySecretaryId(Request $request){
		$secretaryId = intval($request->secretaryId);
		$this->data['listSecretariat'] = $this->register->getDepartmentBySecretariatId($secretaryId);
		return $this->data['listSecretariat'];
	}
	public function postGetOfficeByDepartmentId(Request $request){
		$departmentId = intval($request->departmentId);
		$this->data['listOffice'] = $this->register->getOfficeByDepartmentId($departmentId);
		return $this->data['listOffice'];
	}
	public function getGuestLogout(){
        Session::forget('sessionUser');
        Session::forget('sessionGuestUser');
		Session::forget('feeling_id');
        return redirect('/login');
    }
    public function postRefreshCaptcha(){
		return captcha_img('');
	}	
    public function postChangePassword(Request $request){
		$result = $this->register->modChangePassword($request);
		if($result== true){
			return json_encode(array('code'=>1,'message'=>trans('officer.captcha_changed')));
		}else{
			return json_encode(array('code'=>0,'message'=>trans('officer.invalid_username_pwd')));
		}
	}
	
	/* Reset password */
	public function getResetPassword()
    {
		return view($this->viewFolder.'.register.reset_password')->with($this->data);
    }
	
	public function postResetPassword(Request $request)
    {
		$data_return = $this->register->postResetPassword($request->all());
		if($data_return["code"] == 0){
			return Redirect::back()
                ->withInput()
                ->withErrors([
                    'credentials' => $data_return["message"]
                ]);
		}
		$data = $data_return["data"];
        Mail::send('email.reset_password', ['data' => $data], function ($m) use ($data) {
            $m->from('smartoffice@mef.gov.kh',trans('officer.forget_password'));
            $m->to($data->EMAIL, $data->FULL_NAME_KH)->subject(trans('trans.project_name'));
        });
		$message = trans('officer.confirm_account_by_mail');
		flash($message, 'success');
		return redirect('/login');
    }
	public function getResetPasswordAction(Request $request){
		$data_return = $this->register->getResetPasswordAction($request);
		if($data_return["code"] == 0){
			$this->data["error_message"] = $data_return["message"];
			return view($this->viewFolder.'.register.error_reset_pw')->with($this->data);
		}else{
			$this->data["hashkey"] = $data_return["data"]->HASHKEY;
			return view($this->viewFolder.'.register.form_reset')->with($this->data);
		}
	}
	public function postResetPasswordAction(Request $request){
		$data_return = $this->register->getResetPasswordAction($request);
		if($data_return["code"] == 0){
			$this->data["error_message"] = $data_return["message"];
			return view($this->viewFolder.'.register.error_reset_pw')->with($this->data);
		}else{
			$data_return = $this->register->postResetPasswordAction($data_return["data"],$request);
			if($data_return["code"] == 0){
				if($data_return["code"] == 0){
					return Redirect::back()
						->withInput()
						->withErrors([
							'credentials' => $data_return["message"]
						]);
				}
			}else{
				$message = $data_return["message"];
				Session::flash('username' , $data_return["data"]->user_name);
				flash($message, 'success');
				return redirect('/login');
			}
		}
	}
	/* Reset password End */
}
