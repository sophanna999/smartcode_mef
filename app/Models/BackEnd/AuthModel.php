<?php
namespace App\Models\BackEnd;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Config;
class AuthModel
{

    public function __construct()
    {
        $this->constant = Config::get('constant');
        $this->table = Config::get('table');
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
                        $query->where('off.user_name',$data_request['user_name']);
                    }
                }else{
                    $query->where('p.EMAIL',$data_request['user_name']);
                }
            })
            //By Menglay for select info not approve
            ->whereRaw("IFNULL(off.approve,'')=''")
            ->select(
                'u.id',
                'off.user_name',
                'u.password',
                'u.active',
                'u.moef_role_id',
                'u.mef_ministry_id',
                'u.mef_general_department_id',
                'u.mef_department_id',
                'u.mef_office_id',
                'u.mef_officer_id',
                'u.mef_member_id',
                'p.AVATAR AS avatar'
            )
            ->first();
        return $affected;
    }
    public function postLogin($data,$switch = false){
        $login_type = filter_var( $data['user_name'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'user_name';
        $data_login = $this->postBackendLoginType($data,$login_type);
        if($data_login == null){
            return 0;
        }else{
            if($data_login->active == 0) return 1;
        }

        if ((isset($data['password']) && Hash::check($data['password'], $data_login->password)) || $switch){
            $array = array('last_login_date'=>date('Y-m-d H:i:s'));
            DB::table($this->table['MEF_USER'])->where('id', $data_login->id)->update($array);
            Session::put('sessionUser', $data_login);
            return 2;
        }else{
            return 0;
        }
    }

    /* Frontend User Login*/
    public function postFrontEndLoginType($data_request,$login_type){
        $affected = DB::table('mef_officer')
            ->join('mef_service_status_information', 'mef_service_status_information.MEF_OFFICER_ID', '=', 'mef_officer.Id')
            ->join('mef_personal_information', 'mef_personal_information.MEF_OFFICER_ID', '=', 'mef_officer.Id')
            ->where(function($query) use ($data_request,$login_type){
                if ($login_type == 'user_name') {
                    $query->where('mef_officer.user_name',$data_request['user_name']);
                }else{
                    $query->where('mef_personal_information.EMAIL',$data_request['user_name']);
                }
            })
            //By Menglay for select info not approve
            ->whereRaw("IFNULL(mef_officer.approve,'')=''")
            ->select(
                'mef_officer.Id',
                'mef_officer.user_name',
                'mef_personal_information.EMAIL',
                'mef_officer.password',
                'mef_officer.is_register',
                'mef_officer.is_visited',
                'mef_officer.active',
                'mef_officer.generate_id',
                'mef_service_status_information.CURRENT_GENERAL_DEPARTMENT as mef_dep',
	            'mef_service_status_information.CURRENT_DEPARTMENT as department'

            )
            ->first();
        return $affected;
    }
	public function postGuestLogin($data,$switch = false){
        $login_type = filter_var( $data['user_name'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'user_name';
        $data_login = $this->postFrontEndLoginType($data,$login_type);
        if($data_login == null){
            return 0;
        }else{
            if($data_login->active == 0) return 1;
        }
		$firebaseToken = isset($_COOKIE['firebaseToken']) ? $_COOKIE['firebaseToken']:'';
//        dd($firebaseToken);
        if ((isset($data['password']) && Hash::check($data['password'], $data_login->password)) || $switch){
            //Update officer datetime logged in
            DB::table('mef_officer')
                ->where('Id', $data_login->Id)
                ->update(['last_login_date' => date('Y-m-d H:i:s')]);
				$is_admin = $this->checkAdmin($data_login->Id);
            $arraySession = array(
                'Id'                =>$data_login->Id,
                'user_name'         =>$data_login->user_name,
                'last_login_date'   =>date('Y-m-d H:i:s'),
                'mef_dep'           =>$data_login->mef_dep,
                'is_register'       =>$data_login->is_register,
                'is_visited'        =>$data_login->is_visited,
                'active'            =>$data_login->active,
                'generate_id'       =>$data_login->generate_id,
	            'gen_dep'           =>$data_login->mef_dep,
	            'department'        =>$data_login->department,
				'is_admin'    =>$is_admin
            );
            if($firebaseToken !=''){
	            $arrayDiviceId = array(
		            'mef_office_id'     =>$data_login->Id,
		            'device_id'         =>$firebaseToken
	            );
	            $getDiveId = DB::table('mef_device_id')
		            ->where('mef_office_id',$data_login->Id)
		            ->where('device_id',$firebaseToken)->count();
	            if(!$getDiveId){
		            $diviceId = DB::table('mef_device_id')->insert($arrayDiviceId);
	            }
            }

            Session::put('sessionGuestUser', (object)$arraySession);
			$this->check_tl = session('attendance_mail');
			if($this->check_tl){
				Session::forget('attendance_mail');
				return redirect('attendance/user-req/'.$this->check_tl);
			}
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
	public function checkAdmin($officer_id){
		return $is_admin = DB::table('mef_user')->where('mef_officer_id',$officer_id)->whereActive(1)->count();
	}
}
?>
