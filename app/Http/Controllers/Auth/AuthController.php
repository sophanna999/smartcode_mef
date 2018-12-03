<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Validation\ValidationUser;
use Config;
use Illuminate\Support\Facades\Session;
use App\Models\BackEnd\AuthModel;
use App\Validation\ValidationAuth;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    public function __construct(){
        $this->data = array();
		$this->auth = new AuthModel;
        $this->constant = Config::get('constant');
        $this->data["html_title"] = 'ការិយាល័យវៃឆ្លាត';
        $this->data['constant'] = $this->constant;
		$this->Validation = new ValidationAuth;
        $this->viewFolder = "auth";
    }

    public function getIndex() {

        if(session('sessionUser')){
            return redirect(secret_route().'/dashboard');
        }

        return view($this->viewFolder.'.login')->with($this->data);
    }
    
    /* Backend User Login */
    public function postLogin(Request $request){
        /* Validation Login */
        $validator = $this->Validation->validationLogin($request->all());
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        /* Call failed attempts login */
        $login_type = filter_var( $request['user_name'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'user_name';
        $user_row = $this->auth->postBackendLoginType($request->all(),$login_type);
        $user_id = $user_row != null ? $user_row->id:'';
        /* Login action */
        $isValid = $this->auth->postLogin($request->all());//dd($isValid);
        if ($isValid == 0) {
            if($user_row != null){
                $attempts_data = array(
                  'user_id'         =>$user_id,
                  'ip_address'      =>$request->ip(),
                  'date_time'       =>date('Y-m-d H:i:s'),
                  'is_backend_user' =>1  
                );
                $this->auth->saveFailedLoginAttempts($attempts_data); 
            }
            $failed_attempt = $this->auth->getFailedLoginAttempts($user_id,1);//dd($failed_attempt);
            $credentials = $failed_attempt < 3 ? trans('auth.failed'):trans('auth.failed_attempts_loggin');
            return Redirect::back()->withInput()->withErrors(['credentials' =>$credentials]);
        }else if($isValid == 1){
            return Redirect::back()->withInput()->withErrors(['credentials' =>trans('auth.account_suspend')]);
        }else{
            $failed_attempt = $this->auth->getFailedLoginAttempts($user_id,1);
            if($failed_attempt > 3){
                return Redirect::back()->withInput()->withErrors(['credentials' =>trans('auth.failed_attempts_loggin')]);
            }
            /* Login Successfully */
            return redirect($this->constant['secretRoute'].'/dashboard');
        }
    }

    /* 
    Frontend User Login 
    */
	public function postGuestLogin(Request $request){
        /* Validation Login */
        $validator = $this->Validation->validationLogin($request->all());
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        /* Call failed attempts login */
        $login_type = filter_var( $request['user_name'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'user_name';
        $user_row = $this->auth->postFrontendLoginType($request->all(),$login_type);
        $user_id = $user_row != null ? $user_row->Id:'';
        $isValid = $this->auth->postGuestLogin($request->all());
        if ($isValid == 0) {
            if($user_row != null){
                $attempts_data = array(
                  'user_id'            =>$user_id,
                  'ip_address'         =>$request->ip(),
                  'date_time'          =>date('Y-m-d H:i:s'),
                  'is_backend_user'    =>0
                );
                $this->auth->saveFailedLoginAttempts($attempts_data); 
            }
            $failed_attempt = $this->auth->getFailedLoginAttempts($user_id,0);
            $credentials = $failed_attempt < 3 ? trans('auth.failed'):trans('auth.failed_attempts_loggin');
            return Redirect::back()->withInput()->withErrors(['credentials' =>$credentials]);
        }else if($isValid == 1){
            /* User Suspend */
            return Redirect::back()->withInput()->withErrors(['credentials' =>trans('auth.account_suspend')]);
        }else{
            $failed_attempt = $this->auth->getFailedLoginAttempts($user_id,0);    
            if($failed_attempt > 3){
                return Redirect::back()->withInput()->withErrors(['credentials' =>trans('auth.failed_attempts_loggin')]);
            }
            /* Login Successfully */
//            return redirect('/emoji');
            return redirect('/');
        }
    }

    /* Backend User Logout Session*/
    public function getLogout(){
        Session::forget('sessionGuestUser');
        Session::forget('sessionUser');
        return redirect('/auth');
    }
}
