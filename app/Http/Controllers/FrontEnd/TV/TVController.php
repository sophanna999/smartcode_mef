<?php 
namespace App\Http\Controllers\FrontEnd\TV;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class TVController extends Controller {
	public $data = array();
    public function __construct(){
        $this->session = session('sessionTV');
    }

	public function getIndex(){
        if($this->session == null){
            return view('auth.tv-login')->with($this->data);
        }
        return redirect('tv/schedule');
	}

	public function getSchedule(){
		if($this->session == null){
            Redirect::to('/tv')->send();
        }else{
//            $today = date('Y-m-d');
//            $department_id = $this->session->mef_department_id;
//            $this->data["nearlyMeeting"] = DB::select(DB::raw("CALL get_meeting_by_department('".$today."',$department_id)"));
//            $this->data["query"] = DB::select(DB::raw("CALL get_meeting_by_department('".$today."',$department_id)"));
//            $this->data["lastId"]= DB::table('mef_meeting')->orderBy('Id', 'desc')->first();
//            $this->data['create_date'] = DB::table('mef_meeting')->orderBy('create_date', 'desc')->first();
//			$this->data['count'] = count($this->data["query"]);
			return view('front-end.tv.index');
		}
		
	}
    public function postAllData(Request $request){
        
        $today = date('Y-m-d');
        $department_id = $this->session->mef_department_id;
//        $this->data["nearlyMeeting"] = DB::select(DB::raw("CALL get_meeting_by_department('".$today."',$department_id)"));
        $this->data["query"] = DB::select(DB::raw("CALL get_meeting_by_department('".$today."',$department_id)"));
        $this->data["lastId"]= DB::table('mef_meeting')->orderBy('Id', 'desc')->first();
        $maxId = DB::table('mef_meeting')->orderBy('create_date', 'desc')->first();
        $this->data['lastId'] = isset($maxId->create_date) ? $maxId->create_date: '';
	    $this->data['count'] = count($this->data["query"]);
	    return $this->data;
        
    }
    public function getNewData(Request $request){
        $today = date('Y-m-d');
        $time = date("G:i:s");
        $department_id = $this->session->mef_department_id;
        $maxId = DB::table('mef_meeting')->orderBy('create_date', 'desc')->first();
	    $count = DB::select(DB::raw("CALL get_meeting_by_department('".$today."',$department_id)"));
        $date = isset($maxId->create_date) ? $maxId->create_date:'';
        if($date > $request->create_date || count($count) != $request->count){

            $this->data["query"] = DB::select(DB::raw("CALL get_meeting_by_department('".$today."',$department_id)"));
            $this->data['lastId'] = $maxId->create_date;
	        $this->data['count'] = count( $this->data["query"]);
        }else{
            $this->data['lastId'] = $request->create_date;
	        $this->data['count'] = count($count);
        }

        return $this->data;
    }
	public function postSchedule(){
	    $today = date('Y-m-d');
	    $department_id = 5;
		$query = DB::select(DB::raw("CALL get_meeting_by_department('".$today."',$department_id)"));
		return $query;
	}
	public function postLogin(Request $request){
		/* Call failed attempts login */
        $login_type = filter_var( $request['user_name'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'user_name';
        $user_row = $this->postBackendLoginType($request->all(),$login_type);
        $user_id = $user_row != null ? $user_row->id:'';
        /* Login action */
        $isValid = $this->getLoginData($request->all());//dd($isValid);
        if ($isValid == 0) {
            if($user_row != null){
                $attempts_data = array(
                  'user_id'         =>$user_id,
                  'ip_address'      =>$request->ip(),
                  'date_time'       =>date('Y-m-d H:i:s'),
                  'is_backend_user' =>1  
                );
                $this->saveFailedLoginAttempts($attempts_data); 
            }
            $failed_attempt = $this->getFailedLoginAttempts($user_id,1);//dd($failed_attempt);
            $credentials = $failed_attempt < 3 ? trans('auth.failed'):trans('auth.failed_attempts_loggin');
            return Redirect::back()->withInput()->withErrors(['credentials' =>$credentials]);
        }else if($isValid == 1){
            return Redirect::back()->withInput()->withErrors(['credentials' =>trans('auth.account_suspend')]);
        }else{
            $failed_attempt = $this->getFailedLoginAttempts($user_id,1);
            if($failed_attempt > 3){
                return Redirect::back()->withInput()->withErrors(['credentials' =>trans('auth.failed_attempts_loggin')]);
            }
            /* Login Successfully */
            return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
        }
		
	}
	
	/* Backend User Login*/
    public function postBackendLoginType($data_request,$login_type){

        $affected = DB::table('mef_user AS u')
            ->leftJoin('mef_personal_information AS p','p.MEF_OFFICER_ID','=','u.mef_officer_id')
            ->leftJoin('mef_officer AS off','off.Id','=','u.mef_officer_id')
            ->where(function($query) use ($data_request,$login_type){
                if ($login_type == 'user_name') {
                    if($data_request['user_name'] == 'administrator'){
                        $query->where('u.user_name',$data_request['user_name']);
                    }else{
                        $query->where('u.user_name',$data_request['user_name']);
                    }
                }else{
                    $query->where('p.EMAIL',$data_request['user_name']);
                }
            })
            ->select(
                'u.id',
                'u.user_name',
                'u.password',
                'u.active',
                'u.moef_role_id',
                'u.mef_general_department_id',
                'u.mef_department_id',
                'u.mef_officer_id',
                'p.AVATAR AS avatar'
            )
            ->first();
//        dd($affected);
        return $affected;
    }
    public function getLoginData($data){
        $login_type = filter_var( $data['user_name'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'user_name';
        $data_login = $this->postBackendLoginType($data,$login_type);

        if($data_login == null){
            return 0;
        }else{
            if($data_login->active == 0) return 1;
        }
        if (Hash::check($data['password'], $data_login->password)){
            $array = array('last_login_date'=>date('Y-m-d H:i:s'));
            DB::table('mef_user')->where('id', $data_login->id)->update($array);
            Session::put('sessionTV', $data_login);
            return 2;
        }else{
            return 0;
        }
    }
	public function saveFailedLoginAttempts($data = array()){
        $affected = DB::table('mef_failed_attempts_logging_in')
                ->insert($data);
        return $affected;        
    }
    public function getFailedLoginAttempts($user_id,$is_backend_user){
        $attempt = 0;
        $result = DB::table('v_failed_login_attempts')
                    ->select('failed')
                    ->where('user_id',$user_id)
                    ->where('is_backend_user',$is_backend_user)
                    ->first();
        if($result != null){
            $attempt = $result->failed;
        }
        return $attempt;
    }
	/* Backend User Logout Session*/
    public function getLogout(){
        Session::forget('sessionTV');
        return redirect('/tv');
    }
}
